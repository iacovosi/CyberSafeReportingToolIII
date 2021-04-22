<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Validator;

use App\GroupPermissions;
use App\Group;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;

class RoleController extends Controller
{
    /*
    * This function returns all the permissions available in this project.
    *
    * The ideas is based on view, edit, create, delete.
    */  
    public function all_permissions()
    {
        $groups = Group::all();
        $permissions = ['view', 'edit', 'create', 'delete'];

        $all_permissions = array();

        foreach($groups as $group){
            foreach($permissions as $permission){
                array_push($all_permissions, $permission.'_'.$group->name);
            }
        }

        return $all_permissions;
    }


    public function remove_all_permissions(Role $role)
    {
        $all_permissions = $this->all_permissions();
        
        foreach($all_permissions as $permission){
            $role->revokePermissionTo($permission);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $roles = Role::all();
        $groups = Group::all();
        return view('admin-panel.roles.index', ['roles' => $roles, 'groups'=> $groups, 'permissions' => ['view', 'edit', 'create', 'delete']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);

        foreach ($request->except('_token', 'name') as $key => $value) {
            $role->givePermissionTo($key);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {
        $groups = Group::all();
        return view('admin-panel.roles.edit', ['role' => $role, 'groups'=> $groups, 'permissions' => ['view', 'edit', 'create', 'delete']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
        ]);

        $role->name = $request->name;
        $role->save();
        $this->remove_all_permissions($role);

        foreach ($request->except('_token', 'name', '_method') as $key => $value) {
            $role->givePermissionTo($key);
        }

        Session::flash('message', 'Successfully updated role!');        
        return redirect('/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $role->delete();
        
    }
}
