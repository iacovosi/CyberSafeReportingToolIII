@extends('layouts.app')
@section('links-scripts')

@endsection
@section('content')
<div class="container page-permissions">
  <div class="panel panel-default">
      <div class="panel-heading">
          <ul>
              <li><i class="fa fa-file-text-o"></i>Roles</li>
              <a href="#" class="add-modal">
                  <li>Add Role</li>
              </a>
          </ul>
      </div>

      <div class="panel-body">
          <table class="table table-striped table-bordered table-hover" id="roleTable" style="visibility: hidden;">
              <thead>
                  <tr>
                      <th valign="middle">#</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Description</th>
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
                            {{$role->display_name}}
                        </td>
                        <td>
                            {{$role->description}}
                        </td>

                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $role->updated_at)->diffForHumans() }}</td>
                        <td class="text-center">
                          <button  class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span>View</button>
                          <a href="{{url('roles',['role' => $role->id])}}"><button  class="btn btn-info"><span class="glyphicon glyphicon-edit"></span>Edit</button></a>
                          <button class="btn btn-danger" id="delete-this" data-target="roles" data-id="{{ $role->id }}"> <span class="glyphicon glyphicon-trash"></span>Delete</button>

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
                                <label for="name">Permision Name:</label>
                              <input type="text" name="name"  class="form-control" value="" id="name" placeholder="Give a 1 word lowercase Role e.g admin">
                                <p class="errorTitle text-center alert alert-danger hidden"></p>
                                 </div>

                        </div>
                    </div>
                    <div class="form-group">
                          <label class="control-label col-sm-1" for="title"></label>
                        <div class="col-sm-9">
                           <div class="form-group">
                                <label for="display_name">Display Name</label>
                                  <input type="text"  class="form-control" name="display_name" value="" id="display_name" placeholder="E.g. Administrator">
                                 </div>
                            <p class="errorContent text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                      <div class="form-group">
                        <label class="control-label col-sm-1" for="title"></label>
                        <div class="col-sm-9">
                           <div class="form-group">
                          <label for="description">Description:</label>
                          <input type="text" class="form-control" id="description" placeholder="E.g Full priviledges on the site " name="description">
                            <p class="errorContent text-center alert alert-danger hidden"></p>
                            </div>
                          </div>
                    </div>

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
