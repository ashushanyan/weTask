<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\AddMemberRequest;
use App\Http\Requests\Board\StoreRequest;
use App\Http\Requests\Card\UpdateRequest;
use App\Mail\InvitationEmail;
use App\Mail\ValidateEmail;
use App\Models\Board;
use App\Models\Card;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BoardController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(StoreRequest $request)
    {
        $board = Board::create([
            'title' => $request->title,
            'user_id' => Auth::id()
        ]);

        foreach (Card::STATIC_CARDS as $card) {
            Card::create([
                'title' => $card,
                'board_id' => $board->id,
            ]);
        }

        if ($board) {
            return redirect()->back()->with('message', 'success');
        }

        return redirect()->back()->withErrors(['something went wrong']);
    }

    public function show(Board $board)
    {
        $board = $board->load('cards')->toArray();

        return view('boards.show', compact('board'));
    }

    public function edit(Board $board)
    {
        //
    }

    public function update(UpdateRequest $request, Board $board)
    {
        $board->update([
            'title'  => $request->title,
        ]);

        return redirect()->back()->with('message', 'Success');
    }

    public function destroy(Board $board)
    {
        $board->delete();

        return redirect()->back()->with('message', 'Success');
    }

    public function addMember(AddMemberRequest $request)
    {
        $member = User::where('email', $request->email)->first();

        if (!$member->boards()->where('board_id', $request->board_id)->exists() && !(Auth::user()->email === $request->email)) {

            $member->boards()->attach($request->board_id);
            $senderData = Auth::user()->toArray();
            $board = Board::find($request->board_id);

            Mail::to($request->email)->send(new InvitationEmail($senderData, $member->toArray(), $board->toArray()));

            return redirect()->back()->with('message', 'success');
        }

        return redirect()->back()->withErrors(['something went wrong']);
    }
}
