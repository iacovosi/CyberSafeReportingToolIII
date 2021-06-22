<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

use App\AppSettings;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delete_after_helpline_hotline = AppSettings::where('name', '=', 'delete_after_helpline_hotline')->first();


        if(!$delete_after_helpline_hotline){
            return view('settings.index')->with(['delete_after_helpline_hotline' => 0]);
        }

        return view('settings.index')->with(['delete_after_helpline_hotline' => $delete_after_helpline_hotline->value]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'deleteAfterHelplineHotline' => 'integer|min:0',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        AppSettings::updateOrCreate(['name' => 'delete_after_helpline_hotline'], ['value' => $request['deleteAfterHelplineHotline']]);


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
