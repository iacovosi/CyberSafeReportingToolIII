<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\User;

use App\GroupPermission;
use App\Group;
use Auth;
use Response;
use Input;
use Validator;
use Session;
use DB;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        return view('admin-panel.users.index',compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     *
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin-panel.users.create', ['roles' => $roles]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set validation rules for fields
        $request->validate([
            'name' => 'required|max:60|min:2',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'role_names' => 'required',
        ]);

        // Store new user...
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->syncRoles($request->role_names);

        $user->save();

        Session::flash('message', 'Successfully created user!');
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin-panel.users.edit', compact('user','roles'));
    }


    /*
    * Allows to edit yourself.
    */

    public function self_edit(){
        return $this->edit(User::findOrFail(Auth::id()));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        // Custom validation rule
        Validator::extend('pwdvalidation', function($attribute, $value, $parameters)
        {
            if ($value == '') {
                return true;
            } elseif ( ! Hash::check( $value , $parameters[0] ) ) {
                return false;
            } 

            return true;
        });
        
        $messages = [
            'currentPassword.pwdvalidation' => 'Please enter correct current password', 
        ];

        // Set validation rules for fields
        $request->validate([
            'name' => 'required | max:60 | min:2',
            'email' => [
                'required',
                'email', 
                Rule::unique('users')->ignore($user->id),
            ],
            'currentPassword' => 'required_with:newPassword|pwdvalidation:' . $user->password,
            'newPassword' => 'confirmed',
        ], $messages);
     

        // store user
        $user = User::findOrFail($user->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ( $request->newPassword != '')
        {
            $user->password = bcrypt($request->newPassword);
        }

        //update roles
        if ($request->role_names!= null){
            $user->syncRoles($request->role_names);
        }

        
        $user->save();

        Session::flash('message', 'Successfully updated user!');
        return redirect()->back();
    }

        
    /*
    * Allows to update yourself.
    */

    public function self_update(Request $request){
        return $this->update($request, User::findOrFail(Auth::id()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        Session::flash('message', 'Successfully deleted user!');
        return redirect('/users');
    }
}
