<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\Session;

class TaskController extends Controller
{
    // all tasks
    public function index()
    {
        $user = Auth::user()->id; //This line of code will give Authenticated user id.
        $tasks = task::with('user')->where('tasks.user_id', '=', $user)->get()->toArray();
        return array_reverse($tasks);
    }

    // view specific task
    public function view($id)
    {
        $user = Auth::user()->id; //This line of code will give Authenticated user id.
        $task = task::with('user')->where('tasks.user_id', '=', $user)
                                          ->where('tasks.id', '=', $id)->get()->toArray();
        return response()->json($task);
    }

    // add task
    public function add(Request $request)
    {
        $task = new Task([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description
        ]);
        $task->save();

        return response()->json('The task successfully added');
    }

    // edit task
    public function edit($id)
    {
        $task = Task::find($id);
        return response()->json($task);
    }

    // update task
    public function update($id, Request $request)
    {
        $task = Task::find($id);
        $task->update($request->all());

        return response()->json('The task successfully updated');
    }

    // delete task
    public function delete($id)
    {
        $task = Task::find($id);
        $task->delete();

        return response()->json('The task successfully deleted');
    }

}
