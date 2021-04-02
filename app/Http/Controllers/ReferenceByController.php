<?php

namespace App\Http\Controllers;

use App\ReferenceBy;
use Illuminate\Http\Request;
use Session;

class ReferenceByController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referenceBy = ReferenceBy::orderBy("name")->get();
        return view('admin-panel.referenceBy.index', compact('referenceBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin-panel.referenceBy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|unique:resource_types,name',
            'display_name_en' => 'required',
            'display_name_gr' => 'required',
        ]);

        ReferenceBy::create(request(['name','display_name_gr', 'display_name_en','description_gr','description_en']));

        Session::flash('message', 'Successfully created item!');
        return redirect('/referenceBy');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReferenceBy  $referenceBy
     * @return \Illuminate\Http\Response
     */
    public function show(ReferenceBy $referenceBy)
    {
        return view('admin-panel.referenceBy.show', compact('referenceBy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReferenceBy  $referenceBy
     * @return \Illuminate\Http\Response
     */
    public function edit(ReferenceBy $referenceBy)
    {
        return view('admin-panel.referenceBy.edit', compact('referenceBy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReferenceBy  $referenceBy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReferenceBy $referenceBy)
    {
        $this->validate(request(), [
            'name' => 'required|unique:resource_types,name',
            'display_name_en' => 'required',
            'display_name_gr' => 'required',
        ]);

        $referenceBy->update($request->all());

        Session::flash('message', 'Successfully updated item!');        
        return redirect('/referenceBy');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReferenceBy  $referenceBy
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReferenceBy $referenceBy)
    {
        $referenceBy->delete();

        Session::flash('message', 'Successfully deleted item!');
        return redirect('/referenceBy');
    }
}
