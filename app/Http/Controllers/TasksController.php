<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Auth;

class TasksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $tasks = Task::where('user_id', $user->id)->get();
        return response()->json(['tasks' =>  $tasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $newTask = new Task;

        $newTask->title = $request->input('title');
        $newTask->description = $request->input('description');
        $newTask->priority = $request->input('priority');
        $newTask->user_id = $user->id;
        $newTask->save();

        return response()->json(['task' =>  $newTask], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $taskToShow = Task::find($id);

        if(!$taskToShow){
            return response()->json(['message' =>  'Task not found'], 404); 
        }

        return response()->json(['task' =>  $taskToShow], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $taskForUpdate = Task::find($id);

        if(!$taskForUpdate){
            return response()->json(['message' =>  'Task not found'], 404); 
        }

        $taskForUpdate->title = $request->input('title');
        $taskForUpdate->description = $request->input('description');
        $taskForUpdate->priority = $request->input('priority');
        $taskForUpdate->is_done = $request->input('is_done');
        $taskForUpdate->user_id = $user->id;
        $taskForUpdate->save();

        return response()->json(['task' =>  $taskForUpdate], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        return response()->json(['message' =>  'Task deleted'], 200);
    }
}
