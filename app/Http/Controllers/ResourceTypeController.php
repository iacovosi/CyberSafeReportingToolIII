<?php

namespace App\Http\Controllers;

use App\ResourceType;
use Illuminate\Http\Request;
use Session;

class ResourceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resourceType = ResourceType::orderBy("name")->get();
        return view('admin-panel.resourceType.index', compact('resourceType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel.resourceType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|unique:resource_types,name',
            'display_name_en' => 'required',
            'display_name_gr' => 'required',
        ]);

        ResourceType::create(request(['name','display_name_gr', 'display_name_en']));

        Session::flash('message', 'Successfully created item!');
        return redirect('/resourceType');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceType $resourceType)
    {
        return view('admin-panel.resourceType.show', compact('resourceType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceType $resourceType)
    {
        return view('admin-panel.resourceType.edit', compact('resourceType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResourceType $resourceType)
    {
        $this->validate(request(), [
            'name' => 'required|unique:resource_types,name',
            'display_name_en' => 'required',
            'display_name_gr' => 'required',
        ]);

        $resourceType->update($request->all());

        Session::flash('message', 'Successfully updated item!');        
        return redirect('/resourceType');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceType  $resourceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceType $resourceType)
    {
        $resourceType->delete();

        Session::flash('message', 'Successfully deleted item!');
        return redirect('/resourceType');
    }
}
