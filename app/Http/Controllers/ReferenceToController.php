<?php

namespace App\Http\Controllers;

use App\ReferenceTo;
use Illuminate\Http\Request;
use Session;

class ReferenceToController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referenceTo = ReferenceTo::orderBy("name")->get();
        return view('admin-panel.referenceTo.index', compact('referenceTo'));      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel.referenceTo.create');
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

        ReferenceTo::create(request(['name','display_name_gr', 'display_name_en','description_gr','description_en']));

        Session::flash('message', 'Successfully created item!');
        return redirect('/referenceTo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReferenceTo  $referenceTo
     * @return \Illuminate\Http\Response
     */
    public function show(ReferenceTo $referenceTo)
    {
        return view('admin-panel.referenceTo.show', compact('referenceTo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReferenceTo  $referenceTo
     * @return \Illuminate\Http\Response
     */
    public function edit(ReferenceTo $referenceTo)
    {
        return view('admin-panel.referenceTo.edit', compact('referenceTo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReferenceTo  $referenceTo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReferenceTo $referenceTo)
    {
        $this->validate(request(), [
            'name' => 'required|unique:resource_types,name',
            'display_name_en' => 'required',
            'display_name_gr' => 'required',
        ]);

        $referenceTo->update($request->all());

        Session::flash('message', 'Successfully updated item!');        
        return redirect('/referenceTo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReferenceTo  $referenceTo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReferenceTo $referenceTo)
    {
        $referenceTo->delete();

        Session::flash('message', 'Successfully deleted item!');
        return redirect('/referenceTo');
    }
}
