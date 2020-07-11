<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ValidateEmailRequest;
use App\Mail\ValidateEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'  => $request->name,
            'email'  => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        if ($user) {
            $key = Str::random(32);
            $mailData = array_merge($user->toArray(), [
                'key' => $key,
            ]);

            DB::table('email_validate')->insert([
                'user_id' => $user->id,
                'key' => $key]
            );

            Mail::to($request->email)->send(new ValidateEmail($mailData));

            return redirect()->route("view-login")->with('message', 'A verification link has been sent to your email account');
        }

        return redirect()->back()->with('error','something is wrong');
    }

    public function validateEmail($key, $id)
    {
        $count = DB::table('email_validate')
            ->select('*')
            ->where('user_id',  $id)
            ->where('key', $key)
            ->count();

        if ($count > 0 ) {
            User::find($id)->update([
                'email_verified_at' => Carbon::now()
            ]);

            return redirect()->route('view-login');
        }

        return redirect()->back()->withErrors(['Error']);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt([
            'email' => $request['email'],
            'password' => $request['password'],
        ])) {
            if (is_null(Auth::user()->email_verified_at)) {
                Auth::logout();
                return redirect()->back()->withErrors(['Look for the verification email in your inbox and click the link in that email']);
            }

            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['email or password do not match.']);
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
