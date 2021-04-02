@extends('layouts.app') 

@section('content')
<div class="container">

  @if(GroupPermission::usercan('view','users'))

  @include('partials.info')

  <div class="panel panel-default">

    <div class="panel-heading clearfix">
      <h4 class="pull-left"><i class="fa fa-users" aria-hidden="true"></i> Users</h4>
      <div class="pull-right form-actions">
        @if(GroupPermission::usercan('create','users'))
          <a href="/users/create" class="btn btn-primary">
            <i class="fa fa-plus" aria-hidden="true"></i> New
            </a>
          @endif
      </div>
    </div> <!-- end .panel-heading -->

    <div class="panel-body">
      <!-- will be used to show any messages -->
      @if (Session::has('message'))
          <div class="alert alert-info">{{ Session::get('message') }}</div>
      @endif
      <!-- table with users info -->
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Roles</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $key => $user)
              <tr>
                <td>{{ ++$key }}</td>
                <td>{{$user->name}}
                  {{--
                     //when install redis to check if user online
                     @if($user->isOnline())
                       (Online)
                     @endif
                   --}}
                   </td>
                   <td>{{$user->email}}</td>
                   @if( isset($user->roles) )
                     <td>
                       @foreach($user->roles as $role)
                         {{ $role->display_name }}
                       @endforeach
                     </td>
                   @endif
                   <td style='white-space: nowrap'>
                     {{--  To delete an item, a form needs to be created --}}
                  <form method="POST" action="/users/{{$user->id}}">
                    {{--  Other actions are included in the form for styling purposes  --}}
                    @if(GroupPermission::usercan('edit','users'))                                        
                      <a href="{{route('users.edit', $user->id)}}" class="btn btn-default">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                      </a>
                    @endif
                    {{--  Delete button  --}}
                    @if(GroupPermission::usercan('delete','users'))                                        
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-default delete-user">
                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                      </button>
                    @endif
                  </form> 
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> <!-- end .table -->
    </div> <!-- end .panel-body -->

  </div> <!-- end .panel -->

  @endif

</div> <!-- end .container -->
@endsection 

@section('scripts')
<script src="{{ asset('/js/calls/calls.js') }}" charset="utf-8"></script>

<script>
  $('.delete-user').click(function(e){
    e.preventDefault() // Don't post the form, unless confirmed
    if (confirm('Are you sure you want to delete this user?')) {
      // Post the form
      $(e.target).closest('form').submit() // Post the surrounding form
    }
  });
  </script>
@endsection