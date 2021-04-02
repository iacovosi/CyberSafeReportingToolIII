<?php

namespace App\Http\Controllers;

use App\ContentType;
use Illuminate\Http\Request;
use Session;

class ContentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('for')) {
            $contentType = ContentType::where('is_for',request('for'))->orderBy("name")->get();
        } else {
            $contentType = ContentType::orderBy("name")->get();
        }

        return view('admin-panel.contentType.index', compact('contentType'));      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel.contentType.create');
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
            'is_for' => 'required',
            'name' => 'required|unique:resource_types,name',
            'display_name_en' => 'required',
            'description_en' => 'required',
            'display_name_gr' => 'required',
            'description_gr' => 'required',
        ]);

        ContentType::create(request(['name', 'is_for', 'display_name_gr', 'display_name_en','description_gr','description_en']));

        Session::flash('message', 'Successfully created item!');
        return redirect('/contentType');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContentType  $contentType
     * @return \Illuminate\Http\Response
     */
    public function show(ContentType $contentType)
    {
        return view('admin-panel.contentType.show', compact('contentType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContentType  $contentType
     * @return \Illuminate\Http\Response
     */
    public function edit(ContentType $contentType)
    {
        return view('admin-panel.contentType.edit', compact('contentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContentType  $contentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContentType $contentType)
    {
        $this->validate(request(), [
            'is_for' => 'required',
            'name' => 'required|unique:resource_types,name',
            'display_name_en' => 'required',
            'description_en' => 'required',
            'display_name_gr' => 'required',
            'description_gr' => 'required',
        ]);

        $contentType->update($request->all());

        Session::flash('message', 'Successfully updated item!');        
        return redirect('/contentType');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContentType  $contentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContentType $contentType)
    {
        $contentType->delete();

        Session::flash('message', 'Successfully deleted item!');
        return redirect('/contentType');
    }
}
