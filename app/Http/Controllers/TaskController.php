<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Exception;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {
            $perPage = $request->get('per_page', 10);

            $tasks = Task::orderBy('created_at', 'DESC')->paginate($perPage);

            return response([
                'success' => true,
                'message' => $tasks->isEmpty()
                  ? 'No list of tasks found '
                  : 'Tasks successfull retrieved',
                'data' => $tasks,
                'meta' => [
                    'current_page' => $tasks->currentPage(),
                    'last_page' => $tasks->lastPage(),
                    'per_page' => $tasks->perPage(),
                    'total' => $tasks->total()
                ]
            ], 200);
        } catch (\Exception $e) {

            return response([
                'success' => false,
                'message' => 'failed to retrieve task',
                'error' => $e->getMessage()
            ], 500);
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
        try
        {
            $request->validate([
                'title'=>'required'
            ]);
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'due_date' => $request->due_date
            ]);

            if ($task)
            {
                return response([
                    'success' => true,
                    'message' => 'successfully created the task',
                    'data' => $task
                ], 201);
            } else {
                return response([
                    'success' => false,
                    'message' => 'could not create the task'
                ], 200);
            }
        } catch(\Exception $e) {

            return response([
                'success' => false,
                'message' => 'could not create the task, please try again',
                'error' => $e->getMessage()
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
        try
        {
            $task = Task::find($id);
            if ($task)
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Task Found Successfully',
                    'data' => $task
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Task not found',
                ], 404);
            }
        } catch(\Exception $e) {

            return response([
                'success' => false,
                'message' => 'failed to find task, please try again',
                'error' => $e->getMessage()
            ], 500);
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
        try
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
                    'status' => true,
                    'data' => $task
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'could not update the task',
                ], 200);
            }
        } catch(\Exception $e) {

            return response([
                'success' => false,
                'message' => 'could not update the task, please try again',
                'error' => $e->getMessage()
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
        try{
            $task = Task::find($id);
            if ($task)
            {
                $task->delete();
                return response([
                    'success' => true,
                    'message' => 'Task Deleted Successfully',
                ], 200);
            } else {
                return response([
                    'success' => false,
                    'message' => 'could not delete task, task not found',
                ], 404);
            }
        } catch(\Exception $e) {

            return response([
                'success' => false,
                'message' => 'could not delete task, please try again',
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
