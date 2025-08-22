<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\enums\TaskStatus;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderBy = $request->get('orderBy', 'name');
        $orderDirection = $request->get('orderDirection', 'asc');
        $pageSize = $request->get('pageSize', 15);
        $projects = Project::orderBy($orderBy, $orderDirection);

        $search = $request->get('search', '');
        if ($search) {
            $projects = $projects->where('name', 'like', "%{$search}%");
        }

        $statusFilter = $request->get('status');
        if ($statusFilter) {
            $projects = $projects->where('status', $statusFilter);
        }

        $projects = $projects
            ->with('creator:id,name')
            ->paginate(
                $pageSize,
                [
                    'id',
                    'name',
                    'status',
                    'start_date',
                    'end_date',
                    'value',
                    'creator_id',
                ],
            )
            ->withQueryString();

        return Inertia::render('admin/projects/Projects', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(new Project());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $user_id = $request->user()->id;

        $project = new Project();
        $project->name = $request->input('name');
        $project->status = $request->input('status');
        $project->start_date = $request->input('start_date');
        $project->end_date = $request->input('end_date');
        $project->value = $request->input('value');
        $project->creator_id = $user_id;

        $project->save();

        return redirect()
            ->route('projects.show', $project)
            ->with('toastSuccess', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Request $request)
    {
        $orderBy = $request->get('orderBy', 'title');
        $orderDirection = $request->get('orderDirection', 'asc');
        $pageSize = $request->get('pageSize', 15);
        $tasks = $project->tasks()->orderBy($orderBy, $orderDirection);

        $search = $request->get('search', '');
        if ($search) {
            $tasks = $tasks->where('title', 'like', "%{$search}%");
        }

        $statusFilter = $request->get('status');
        if ($statusFilter) {
            $tasks = $tasks->where('status', $statusFilter);
        }

        $tasks = $tasks
            ->with('creator:id,name')
            ->paginate(
                $pageSize,
                [
                    'id',
                    'title',
                    'due_date',
                    'status',
                    'creator_id',
                ],
            )
            ->withQueryString();

        $project->load('creator:id,name');

        return Inertia::render('admin/projects/ProjectView', [
            'project' => $project,
            'canEdit' => $project->creator_id == Auth::user()->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return Inertia::render('admin/projects/ProjectEdit', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->name = $request->input('name');
        $project->status = $request->input('status');
        $project->start_date = $request->input('start_date');
        $project->end_date = $request->input('end_date');
        $project->value = $request->input('value');
        $project->save();

        $taskInactiveStatus = TaskStatus::Inactive->value;
        if ($request->input('status') == $taskInactiveStatus) {
            $project->tasks()
                ->where('status', '<>', $taskInactiveStatus)
                ->update([ 'status' => $taskInactiveStatus ]);
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('toastSuccess', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->creator_id == Auth::user()->id) {
            $project->delete();
            return redirect()
                ->route('projects.index')
                ->with('toastSuccess', 'Project deleted successfully.');
        }

        return redirect()
            ->route('projects.index')
            ->with('toastError', 'You are not authorized to delete this project.');
    }
}
