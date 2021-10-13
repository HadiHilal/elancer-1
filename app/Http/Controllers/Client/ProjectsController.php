<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        //$projects = Project::where('user_id', '=', $user->id)->paginate();
        $projects = $user->projects()->paginate();

        return view('client.projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.projects.create', [
            'project' => new Project(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $user = $request->user();

        // $request->merge([
        //     'user_id' => $user->id, // Auth::id()
        // ]);
        // $project = Project::create($request->all());

        $project = $user->projects()->create( $request->all() );

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        return view('client.projects.show', compact('project'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        return view('client.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        $project->update($request->all());

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project upated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Project::where('user_id', Auth::id())
        //     ->where('id', $id)
        //     ->delete();
        
        $user = Auth::user();
        $user->projects()->where('id', $id)->delete();

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project deleted');
    }
}
