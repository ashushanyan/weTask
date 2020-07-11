<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(StoreRequest $request)
    {
        $task = Task::create($request->all());

        if ($task) {
            return redirect()->back()->with('message', 'success');
        }

        return redirect()->back()->withErrors(['something went wrong']);
    }

    public function show(Task $task)
    {
        $task = $task->load('assignedBy', 'card.board.creator', 'card.board.users');

        $assignedBy = $task->assignedBy;

        $cardCreator = $task->card->board->creator;
        $cardMembers = $task->card->board->users;
        $cards = $task->card->board->cards;

        return view('tasks.show', compact('task', 'assignedBy', 'cardCreator', 'cardMembers', 'cards'));
    }

    public function update(UpdateRequest $request, Task $task)
    {
        $task->update($request->all());

        return redirect()->back()->with('message', 'success');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('message', 'Success');
    }

    public function addArchive(Request $request)
    {
        Task::find($request->task_id)->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('message', 'success');
    }
}
