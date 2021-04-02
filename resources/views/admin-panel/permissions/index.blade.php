@extends('layouts.app')
@section('links-scripts')

@endsection
@section('content')
<div class="container page-permissions">
  <div class="panel panel-default">
      <div class="panel-heading">
          <ul>
              <li><i class="fa fa-file-text-o"></i>Permissions</li>
              <a href="#" class="add-modal">
                  <li>Add Permission</li>
              </a>
          </ul>
      </div>

      <div class="panel-body">
          <table class="table table-striped table-bordered table-hover" id="postTable" style="visibility: hidden;">
              <thead>
                  <tr>
                      <th valign="middle">#</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Auhtorized Roles</th>
                      <th>Last Updated</th>
                      <th>Actions</th>
                  </tr>

              </thead>
              <tbody>
                @if ($permissions)
                      @foreach ($permissions as $indexKey => $permission)
                    <tr class="item{{$permission->id}}">
                        <td class="col1">{{ $indexKey+1 }}</td>
                        <td>{{$permission->id}}</td>
                        <td>
                            {{$permission->display_name}}
                        </td>
                        <td>
                            {{$permission->description}}
                        </td>
                        <td>
                          @foreach ($roles as $role)
                            @foreach ($role->perms()->get() as $permisionrole)
                                @if($permisionrole->id == $permission->id)
                                  {{$role->display_name}}
                                @endif
                            @endforeach
                          @endforeach
                        </td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $permission->updated_at)->diffForHumans() }}</td>
                        <td class="text-center">
                          <button  class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span>View</button>
                          <button  class="btn btn-info"><span class="glyphicon glyphicon-edit"></span>Edit</button>
                          <button class="btn btn-danger" id="delete-this" data-target="permissions" data-id="{{ $permission->id }}"> <span class="glyphicon glyphicon-trash"></span>Delete</button>
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
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-1" for="title"></label>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="name">Permision Name:</label>
                              <input type="text" name=""  class="form-control" value="" id="name" placeholder="Give a name in 1 word.. e.g. post-editor">
                                <p class="errorTitle text-center alert alert-danger hidden"></p>
                                 </div>

                        </div>
                    </div>
                    <div class="form-group">
                          <label class="control-label col-sm-1" for="title"></label>
                        <div class="col-sm-9">
                           <div class="form-group">
                                <label for="display_name">Display Name</label>
                                  <input type="text"  class="form-control" name="" value="" id="display_name" placeholder="E.g Can edit posts">
                                 </div>
                            <p class="errorContent text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                      <div class="form-group">
                        <label class="control-label col-sm-1" for="title"></label>
                        <div class="col-sm-9">
                           <div class="form-group">
                          <label for="description">Description:</label>
                          <input type="text" class="form-control" id="description" placeholder="E.g Permission to edit posts ">
                            <p class="errorContent text-center alert alert-danger hidden"></p>
                            </div>
                          </div>
                    </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success add" data-dismiss="modal">
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
        $('#postTable').removeAttr('style');
    })
</script>
<script type="text/javascript" src="{{ asset('js/admin/permissions.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/calls/calls.js') }}"></script>
@endsection
