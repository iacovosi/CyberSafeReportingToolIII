@extends('layouts.app')
@section('links-scripts')

@endsection
@section('content')
<div class="container page-permissions">
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="pull-left"><i class="fa fa-users" aria-hidden="true"></i> Roles</h4>
        <div class="pull-right form-actions">
          @if(GroupPermission::usercan('create','roles'))
            <a  class="btn btn-primary add-modal">
              <i class="fa fa-plus" aria-hidden="true"></i> New
              </a>
            @endif
        </div>
      </div> <!-- end .panel-heading -->
 <!-- will be used to show any messages -->

        
      <div class="panel-body">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
          <table class="table table-striped table-hover" id="roleTable" style="visibility: hidden;">
              <thead>
                  <tr>
                      <th valign="middle">#</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Last Updated</th>
                      <th>Actions</th>
                  </tr>

              </thead>
              <tbody>
                @if ($roles)
                      @foreach ($roles as $indexKey => $role)
                    <tr class="item{{$role->id}}">
                        <td class="col1">{{ $indexKey+1 }}</td>
                        <td>{{$role->id}}</td>
                        <td>
                            {{$role->name}}
                        </td>

                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $role->updated_at)->diffForHumans() }}</td>
                        <td class="text-center">
                              <a href="{{route('roles.edit', $role->id)}}" class="btn btn-default">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                              </a>
                              <button class="btn btn-default" id="delete-this" data-target="roles" data-id="{{ $role->id }}">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                              </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <p>  There are not any permissions saved yet. Click Add new to create one.</p>
                  @endif
              </tbody>
          </table>
      </div>
      <!-- /.panel-body -->
  </div>
  <!-- /.panel panel-default -->
</div>

<!-- Modal form to add a Permission -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="submit-form">
                    <div class="form-group">
                        <label class="control-label col-sm-1" for="title"></label>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="name">Role Name:</label>
                              <input type="text" name="name"  class="form-control" value="" id="name" placeholder="Give a 1 word lowercase Role e.g admin">
                                <p class="errorTitle text-center alert alert-danger hidden"></p>
                                 </div>

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
                                    <label class="checkbox-inline"><input type="checkbox" name="{{ $permission .'_'.$group->name }}" >
                                        {{ $permission }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    

                </form>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-success add" id="save-this" data-target="roles" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-check'></span> Add

                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>

            </div>
        </div>
    </div>
</div> <!-- End modal -->

@endsection
@section('scripts')
<script>
    $(window).on('load',function() {
        $('#roleTable').removeAttr('style');
    })
</script>
<script type="text/javascript" src="{{ asset('js/calls/modals.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/calls/calls.js') }}"></script>
@endsection
