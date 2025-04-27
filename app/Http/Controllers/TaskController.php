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
                'message' => 'Tasks successfull retrieved',
                'code' => '200',
                'status' => 'true',
                'list' => $tasks
            ]);
        }else{
            return response([
                'message' => 'No list of tasks found',
                'code' => '200',
                'status' => 'false'
            ]);
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
            return response([
                'message' => 'successfully created the task',
                'code' => '200',
                'status' => 'true',
                'task' => $task
            ]);
        } else {
            return response([
                'message' => 'could not create the task',
                'code' => '200',
                'status' => 'false'
            ]);
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
            return response([
                'message' => 'Task Found Successfully',
                'code' => '200',
                'status' => 'true',
                'task' => $task
            ]);
        } else {
            return response([
                'message' => 'Task not found',
                'code' => '404',
                'status' => 'false'
            ]);
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
            return response([
                'message' => 'Task Updated Successfully',
                'code' => '200',
                'status' => 'true',
                'task' => $task
            ]);
        } else {
            return response([
                'message' => 'Task not found',
                'code' => '404',
                'status' => 'false'
            ]);
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
        //
    }
}
