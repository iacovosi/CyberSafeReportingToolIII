@extends('layouts.app') 

@section('content')

<div class="container">
    
    @include('partials.info')
    
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4><i class="fa fa-user-circle-o" aria-hidden="true"></i> User profile</h4>
        </div>

        <div class="panel-body">
            @if (GroupPermission::usercan('edit','users'))
                <div class="alert alert-info" role="alert">
                    To select more than one role hold down the Ctrl key while choosing with your mouse.
                </div>
            @endif
            <form id="form-change-password" class="form-horizontal" role="form" method="POST" 
                action="@if (!\Request::is('profile/edit')){{ route('users.update', $user->id) }} @else {{ route('profile.update') }}  @endif">

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
                        <label for="role" class="col-sm-2 control-label">Roles</label>
                        <div class="col-sm-10">
                            <select multiple class="form-control" multiple="multiple" name="role_names[]">
                                @foreach($roles as $role)
                                    <option  value="{{ $role->name }}"  @if ($user->hasRole($role->name)) selected="selected" @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                @endif

                <div class="form-group"></div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary update-user">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                        </button>
                        <a href="@if (\Request::is('profile/edit')){{ route('home') }} @else {{ route('users.index') }}  @endif"
                             class="btn btn-default">
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
