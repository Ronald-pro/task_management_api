<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'DESC')->get();
        if ($tasks)
        {
            return response([
                'success' => 'true',
                'message' => 'Tasks successfull retrieved',
                'data' => $tasks
            ], 200);
        }else{
            return response([
                'success' => 'false'
                'message' => 'No list of tasks found',
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required'
        ]);
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,

        ]);

        if ($task)
        {
            return response->json([
                'success' => 'true',
                'message' => 'successfully created the task',
                'data' => $task
            ], 201);
        } else {
            return response([
                'success' => 'false'
                'message' => 'could not create the task'
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if ($task)
        {
            return response->json([
                'success' => 'true',
                'message' => 'Task Found Successfully',
                'data' => $task
            ], 200);
        } else {
            return response([
                'success' => 'false'
                'message' => 'Task not found',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required'
        ]);

        $task = Task::find($id);
        if ($task)
        {
            $task->title = $request->title;
            $task->description = $request->description;
            $task->priority = $request->priority;
            $task->due_date = $request->due_date;
            $task->update();
            return response()->json([
                'message' => 'Task Updated Successfully',
                'code' => '200',
                'status' => 'true',
                'data' => $task
            ]);
        } else {
            return response()->json([
                'success' => 'false'
                'message' => 'Could not update the task',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task)
        {
            $task->delete();
            return response()->json([
                'success' => 'true'
                'message' => 'Task Deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => 'false'
                'message' => 'Could not delete task',
            ], 500);
        }
    }
}
