<?php

namespace App\Http\Controllers;

use App\ActionTaken;
use Illuminate\Http\Request;

class ActionTakenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $actions = ActionTaken::all();

        return view('admin-panel.actions.index',['actions' => $actions]);
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
        //

        $hey = ActionTaken::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ActionTaken  $actionTaken
     * @return \Illuminate\Http\Response
     */
    public function show(ActionTaken $actionTaken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ActionTaken  $actionTaken
     * @return \Illuminate\Http\Response
     */
    public function edit(ActionTaken $actionTaken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActionTaken  $actionTaken
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $actionTaken)
    {
        //
        $Updateme = ActionTaken::where('id',$actiontaken)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActionTaken  $actionTaken
     * @return \Illuminate\Http\Response
     */
    public function destroy($actionTaken)
    {
        //
        $deleteme = ActionTaken::where('id',$actionTaken)->first();
        $deleteme->delete();
    }
}
