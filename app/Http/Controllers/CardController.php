<?php

namespace App\Http\Controllers;

use App\Http\Requests\Card\StoreRequest;
use App\Http\Requests\Card\UpdateRequest;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
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
        $card = Card::create($request->all());

        if ($card) {
            return redirect()->back()->with('message', 'success');
        }

        return redirect()->back()->withErrors(['something went wrong']);
    }

    public function show(Card $card)
    {
        $card = $card->load('board.users', 'board.creator', 'tasks');

        $creator = $card->board->creator->toArray();
        $members = $card->board->users->toArray();

        $activeTasks = $card->tasks->where('assigned_to','<>', Auth::id())->where('status', true);
        $myTasks = $card->tasks->where('assigned_to', Auth::id())->where('status', true);

        $archiveTasks = $card->tasks->where('status', false);

        return view('cards.show', compact('card', 'creator', 'members', 'activeTasks', 'myTasks', 'archiveTasks'));
    }

    public function edit(Card $card)
    {
        //
    }

    public function update(UpdateRequest $request, Card $card)
    {
        $card->update([
           'title'  => $request->title,
        ]);

        return redirect()->back()->with('message', 'Success');
    }

    public function destroy(Card $card)
    {
        $card->delete();

        return redirect()->back()->with('message', 'Success');
    }
}
