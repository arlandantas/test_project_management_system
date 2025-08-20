<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
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

        $projects = $projects->paginate(
            $pageSize,
            [
                'id',
                'name',
                'status',
                'start_date',
                'end_date',
                'value',
            ],
        )->withQueryString();

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return Inertia::render('admin/projects/ProjectView', [
            'project' => $project,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
