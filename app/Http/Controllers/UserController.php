<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\GroupPermission;
use App\Group;
use App\Permission;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Auth;
use Response;
use Input;
use Validator;
use Session;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(GroupPermission::usercan('view','users')){
            $users = User::with('UserHasRoles')->get();
            // return view('admin-panel.users.index')->with('users', $users);
            return view('admin-panel.users.index',compact('users'));
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new user.
     *
     */
    public function create()
    {
        /**
         * Perform a validation check if the user can create permissions
         * otherwiser redirect him back
         *
         */
        if (GroupPermission::usercan('create','users')) {
            $roles = Role::all();
            return view('admin-panel.users.create', ['roles' => $roles]);
        } else {
            return redirect()->back();
        }

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
        $rules = [
            'name' => 'required|max:60|min:2',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'role_id'=> 'required',
        ];

        // Generate a new validator instance
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('users/create')
                        ->withErrors($validator)
                        ->withInput($request->except('password'));
        }

        // Store new user...
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        //insert record in role_user for selected role of user
        $user_id=$user->id;
        $role_id=$request->role_id;
        DB::insert('insert into role_user (user_id,role_id) values(?,?)',[$user_id,$role_id]);

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
        // user admin can edit all users profile while...
        // ...A USER can ALSO edit his own profile only!
        if( GroupPermission::usercan('edit','users') || $user->id==Auth::id() ){

            if( GroupPermission::usercan('create','roles') ){
                $groups = Group::all();
            } else {
                $groups = Group::all()->except([3,4]);
            }

            $grouppermissions = GroupPermission::where('user_id',$user->id)->get();
            $permissions = Permission::all();

            $roles = Role::all();

            $role=DB::table('role_user')->select('role_id')->where('user_id', $user->id)->first();
            if (isset($role) && !empty($role)) {
                $role_id = $role->role_id;
            }

            return view('admin-panel.users.edit', compact('user','grouppermissions','groups','permissions','roles','role_id'));
        } else {
            return redirect()->route('home');
        }
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
            // --- NEED TO CHECK THIS AND MAKE IT WORKING ---
            $groups = Group::all()->except([3,4]);            
            \DB::table('group_permissions')->where('user_id',$user->id)->delete();

            $grouppermissions = GroupPermission::select('permission_id','group_id')->where('user_id',$user->id)->get();

            foreach($groups as $group){
                $gname = $group->name;
                if (($request-> $gname) > 0){
                    foreach($request->$gname as $perm){
                        GroupPermission::attachGroupPermission($user->id,$perm,$group->id);
                    }
                }
            }

        if (GroupPermission::usercan('edit','users') || $user->id==Auth::id() ) {

            // Custom validation rule
            Validator::extend('pwdvalidation', function($attribute, $value, $parameters)
            {
                if ($value == '') {
                    return true;
                } elseif ( ! Hash::check( $value , $parameters[0] ) ) {
                    return false;
                } else {
                    return true;
                }
                // return Hash::check($value, $parameters[0]);
            });
            $messages = [
                'currentPassword.pwdvalidation' => 'Please enter correct current password', 
            ];

            // Set validation rules for fields
            $rules = [
                'name' => 'required | max:60 | min:2',
                'email' => [
                    'required',
                    'email', 
                    Rule::unique('users')->ignore($user->id),
                ],
                'currentPassword' => 'pwdvalidation:' . $user->password,
                'newPassword' => 'required_with:currentPassword | confirmed ',
            ];

            // Generate a new validator instance
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect('users/'.$user->id.'/edit')
                            ->withErrors($validator)
                            ->withInput($request->except('password'));
            }            

            // Store...
            $user = User::findOrFail($user->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ( $request->newPassword != '')
            {
                $user->password = bcrypt($request->newPassword);
            }        
            $user->save();
            //update role in user_role
            $user_id=$user->id;
            $role_id=$request->role_id;
            DB::table('role_user')->where('user_id', '=', $user_id)->delete();
            DB::insert('insert into role_user (user_id,role_id) values(?,?)',[$user_id,$role_id]);

            Session::flash('message', 'Successfully updated user!');
            return redirect()->back();

            // if ( $user->id==Auth::id() ) {
            //     return redirect('/home'); 
            // } else {
            //     return redirect('/users');                 
            // } 

        } else {
            return redirect()->back()->with(['error-info' => 'You dont have permissions to edit this user']);
        }
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

        // if ($request->ajax()) {
        //     $user = User::find($id);
        //     $user->delete();
        //     return Response::json();
        // }
    }
}
