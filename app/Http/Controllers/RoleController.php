<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Response;
use Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::all();
        return view('admin-panel.roles.index', ['roles' => $roles]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->ajax()) {
            $role = new Role();
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();

            return Response::json($request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $role = Role::find($id);
        return view('admin-panel.roles.edit', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        return request()->headers->get('referer');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /**
         * Validate the request if has the necessary fields
         * name and display name otherwise redirect
         * back with errors.
         */
        $rules = [
            'name' => 'required',
            'display_name' => 'required',
        ];
        //Permform the validation check with the custom rules above

        $validator = Validator::make($request->all(), $rules);
        //If it fails turn back with the error messages.
        if ($validator->fails()) {
            return Response::json(
                $validator->messages(), 500);
        }
        //The validation check has succeded and the values are going to be
        //Updated and saved.
        else {
            $role = Role::find($id);
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();
            return Response::json($request);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $role = Role::find($id);
            $role->delete();

            return Response::json();
        } else {
            $role = Role::find($id);
            $role->delete();
            return redirect()->back();
        }
    }
}
