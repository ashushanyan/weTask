<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $myBoards = [];

        for ($i = 0; $i < count($boards = array_merge(Auth::user()->boardsByMe->toArray(), ($user =Auth::user())->boards->toArray())); $i++) {
            $myBoards[$i]['id'] = $boards[$i]['id'];
            $myBoards[$i]['title'] = $boards[$i]['title'];
            $myBoards[$i]['created_by'] = User::find($boards[$i]['user_id'])->name;
        }

        return view('home', compact('user','myBoards'));
    }
}
