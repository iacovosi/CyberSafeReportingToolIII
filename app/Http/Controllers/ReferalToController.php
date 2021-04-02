<?php

namespace App\Http\Controllers;

use App\ReferenceTo;
use Illuminate\Http\Request;

class ReferalToController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $referals = ReferenceTo::all();
        return view('admin-panel.referals.index',['referals' => $referals]);
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
        $referals = ReferenceTo::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReferenceTo  $referenceTo
     * @return \Illuminate\Http\Response
     */
    public function show(ReferenceTo $referenceTo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReferenceTo  $referenceTo
     * @return \Illuminate\Http\Response
     */
    public function edit(ReferenceTo $referenceTo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReferenceTo  $referenceTo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $referenceTo)
    {
        //
        $Updateme = ReferenceTo::where('id',$referenceTo)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReferenceTo  $referenceTo
     * @return \Illuminate\Http\Response
     */
    public function destroy($referenceTo)
    {
        //
        $deleteme = ReferenceTo::where('id',$referenceTo)->first();
        $deleteme->delete();
    }
}
