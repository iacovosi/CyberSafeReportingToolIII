@extends('layouts.app') 

@section('content')

<div class="container">
    
    @include('partials.info')
    
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4><i class="fa fa-user-circle-o" aria-hidden="true"></i> User profile</h4>
        </div>

        <div class="panel-body">

            {{--  
            To call the update() method, you must make a PUT request. 
            But HTML forms can't make PUT requests. 
            So, Laravel provids a way to mimick a PUT request with forms  
            --}}
            <form id="form-change-password" class="form-horizontal" role="form" method="POST" action="/users/{{$user->id}}">

                <input type="hidden" name="_method" value="PUT" />

                {{ csrf_field() }}

                <legend>Identification</legend>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{$user->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" value="{{$user->email}}">
                    </div>
                </div>

                <legend>Password</legend>
                
                <div class="form-group">
                    <label for="currentPassword" class="col-sm-2 control-label">Current Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="currentPassword" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="newPassword" class="col-sm-2 control-label">New Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="newPassword" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="newPassword_confirmation" class="col-sm-2 control-label">Re-enter Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="newPassword_confirmation" class="form-control">
                    </div>
                </div>

                @if (GroupPermission::usercan('edit','users'))
                    <div class="form-group">
                        <label for="role" class="col-sm-2 control-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"  @if (!empty($role_id) && ($role_id ==$role->id)) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                <legend>Permissions</legend>

                @foreach($groups as $group)
                    <div class="form-check">
                        <label class="form-check-label col-sm-2 control-label">
                            {{ $group->name }}
                        </label>
                
                        <div class="col-sm-10" name="{{ $group->name }}">
                            @foreach($permissions as $permission)
                                <label class="checkbox-inline"><input type="checkbox" value="{{ $permission->id }}" name="{{ $group->name }}[]" @if(GroupPermission::canuser($user->id,$permission->name,$group->name)) checked @endif>
                                    {{ $permission->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="form-group"></div>

                @endif

                <div class="form-group"></div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary update-user">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                        </button>
                        <a href="{{route('users.index')}}" class="btn btn-default">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Cancel
                        </a>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-0 col-sm-12">
                        @include('partials.errors')
                    </div>
                </div>

                <!-- will be used to show any messages -->
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('/js/calls/calls.js')}}"></script>
    <script src="{{ asset('/js/calls/display.js') }}"></script>
    <script>
        $('.update-user').click(function(e){
            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm('Are you sure you want to update this user profile?')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
