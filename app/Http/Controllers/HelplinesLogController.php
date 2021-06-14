<?php

namespace App\Http\Controllers;

use App\HelplinesLog;
use Illuminate\Http\Request;

class HelplinesLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('logs.index')->with([]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HelplinesLog  $helplines_log
     * @return \Illuminate\Http\Response
     */
    public function timeline(Request $request)
    {
        $helplineslog = HelplinesLog::where('reference_id',$request->id)->get();
 
        return view('logs.show')->with(['helplineslog' => $helplineslog, 'id' => $request->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HelplinesLog  $helplines_log
     * @return \Illuminate\Http\Response
     */
    public function show(HelplinesLog $log)
    {

        return view('logs.more')->with(['log' => $log]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HelplinesLog  $helplines_log
     * @return \Illuminate\Http\Response
     */
    public function edit(HelplinesLog $helplines_log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Helplines_log  $helplines_log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HelplinesLog $helplines_log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Helplines_log  $helplines_log
     * @return \Illuminate\Http\Response
     */
    public function destroy(HelplinesLog $helplines_log)
    {
        //
    }
}
