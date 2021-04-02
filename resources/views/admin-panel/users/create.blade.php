@extends('layouts.app') 

@section('content')

@if(GroupPermission::usercan('create','users'))

<div class="container">
        
  <div class="panel panel-default">

    <div class="panel-heading clearfix">
      <h4><i class="fa fa-user-circle-o" aria-hidden="true"></i> New user</h4>
    </div>

    <div class="panel-body">
      <form id="create-new-user" class="form-horizontal" method="POST" action="/users">

        {{ csrf_field() }}

        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{old('name')}}">
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{old('email','')}}">
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10">          
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" value="">
          </div>
        </div>
        {{--
        @foreach($roles as $role)
          <div class="form-check">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox" id="{{ $role->name }}" value="{{ $role->name }}" aria-label="...">{{ $role->display_name }}
            </label>
          </div>
        @endforeach
        --}}

        <div class="form-group">
          <label for="role" class="col-sm-2 control-label">Role</label>
          <div class="col-sm-10">
            <select class="form-control" name="role_id">
              @foreach($roles as $role)
                  <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
        </div>


        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">
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
      </form>

    </div> <!-- end .panel-body -->
  </div> <!-- end .panel -->
</div> <!-- end .container -->

@endif

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/calls/calls.js') }}"></script>
@endsection
