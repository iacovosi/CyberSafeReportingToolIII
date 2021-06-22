<?php

namespace App\Http\Controllers;

use App\HelplinesLog;
use Illuminate\Http\Request;
use Session;
use App\Status;
use App\Helpline;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class HelplinesLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fromDate' => 'date',
            'toDate' => 'date|after:fromDate',
        ]);


        if($validator->fails() && ($request->fromDate || $request->toDate)){
            Session::flash('error-info', 'Wrong date format, ignored.');
            $request->fromDate = null;
            $request->toDate = null;
        }

        $status = Status::all();

        // defaulting
        if (!$request->fromDate){
            $request->fromDate="1990-01-01";
        }
        if (!$request->toDate){
            $request->toDate="2100-01-01";
        }
        if (!$request->filterStatus){
            $request->filterStatus="*";
        }

        $start = Carbon::parse($request->fromDate);
        $end = Carbon::parse($request->toDate);

        
        $unique_id = \DB::table('helplines_logs')
            ->select('reference_id')
            ->groupBy('reference_id')
            ->get();


        $a = [];

        foreach ($unique_id as $id){

            $item = HelplinesLog::where('reference_id', '=', $id->reference_id)
            ->orderBy('created_at','DESC')->first();

            if ($item->created_at >= $start && $item->created_at <= $end &&  ($request->filterStatus === "*" || $request->filterStatus === $item->status ))
                array_push($a, $item);
        }

        return view('logs.index')->with(['logs' => $a, 'status' => $status]);
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
        $helplineslog = HelplinesLog::where('reference_id', $request->id)->get();

        $helpline = Helpline::find($request->id);
 
        return view('logs.show')->with(['helplineslog' => $helplineslog, 'id' => $request->id, 'helpline' => $helpline]);
    }


    public function recover(Request $request){
        Helpline::recover($request->id);

        return redirect()->back();
    }

    public function archieve(Request $request){
        Helpline::archieve($request->id);

        return redirect()->back();
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
    public function destroy(Request $request)
    {

        HelplinesLog::where('reference_id', '=', $request->id)->delete();
        
        Session::flash('message', 'Successfully deleted log!');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Helplines_log  $helplines_log
     * @return \Illuminate\Http\Response
     */
    public function mass_destroy(Request $request)
    {
        if (!$request->selected_ids){
            return response(['Message'=>'Wrong Input'], 400);
        }

        foreach ($request->selected_ids as $id){
            HelplinesLog::where('reference_id', '=', $id)->delete();
        }

        return response(['Message'=>'Delete Succesful'], 200);
    }
}
