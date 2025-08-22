<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = new Task();
        $task->creator_id = $request->user()->id;
        $task->project_id = $request->input('project_id');
        $task->title = $request->input('title');
        $task->status = $request->input('status');
        $task->due_date = $request->input('due_date');
        $task->save();

        return redirect()
            ->route('projects.show', [ 'project' => $task->project_id ])
            ->with('toastSuccess', 'Task created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->title = $request->input('title');
        $task->status = $request->input('status');
        $task->due_date = $request->input('due_date');
        $task->save();

        return redirect()
            ->route('projects.show', [ 'project' => $task->project_id ])
            ->with('toastSuccess', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, Request $request)
    {
        if ($request->user()->cannot('delete', $task)) {
            return redirect()
                ->route('projects.show', $task->project_id)
                ->with('toastError', 'You do not have permission to delete this task.');
        }

        $task->delete();
        return redirect()
            ->route('projects.show', $task->project_id)
            ->with('toastSuccess', 'Task deleted successfully.');
    }
}
