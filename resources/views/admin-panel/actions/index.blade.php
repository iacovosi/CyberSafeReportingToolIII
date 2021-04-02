@extends('layouts.app') @section('links-scripts') @endsection @section('content')
<div class="container page-contenttypes margin-me">
    @include('partials.info')
    <div class="panel panel-default">
        <div class="panel-heading">
            <ul>
                <li><i class="fa fa-file-text-o"></i>Actions</li>
                <a href="#" class="add-modal">
                    <li>Add Action</li>
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
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>

                </thead>
                <tbody>
                    @if ($actions) @foreach ($actions as $indexKey => $item)
                    <tr class="item{{$item->id}}">
                        <td class="col1">{{ $indexKey+1 }}</td>
                        <td>{{$item->id}}</td>
                        <td>
                            {{$item->name}}
                        </td>

                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at)->diffForHumans() }}</td>
                        <td class="text-center">
                            <button class="btn btn-success view-this"  data-name="{{ $item->name }}"><span class="glyphicon glyphicon-eye-open"></span>View</button>
                           <button  class="btn btn-info update-this" data-id="{{ $item->id }}" data-name="{{ $item->name }}"><span class="glyphicon glyphicon-edit"></span>Edit</button>
                            <button class="btn btn-danger" id="delete-this" data-target="actions" data-id="{{ $item->id }}"> <span class="glyphicon glyphicon-trash"></span>Delete</button>

                        </td>
                    </tr>
                    @endforeach @else
                    <p> There are not any permissions saved yet. Click Add new to create one.</p>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel panel-default -->
    @include('partials.errors')
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
                                <label for="name">Resource Name:</label>
                                <input type="text" name="name" class="form-control" value="" id="name" placeholder="Name it..">
                                <p class="errorTitle text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success add" id="save-this" data-target="actions" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-check'></span> Add

                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- End modal -->
<!-- View Modal-->

<div id="view-modal" class="modal fade" role="dialog">
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
                                <label for="name">Resource Name:</label>
                                <input type="text" name="name" class="form-control" value="" id="name" disabled>
                                <p class="errorTitle text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>
<!--End of View Modal-->
<!-- Edit Modal-->

<div id="update-modal" class="modal fade" role="dialog">
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
                                <label for="name">Resource Name:</label>
                                <input type="text" name="name" class="form-control"  id="name" >
                                <p class="errorTitle text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                    </div>


                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info update-content" data-dismiss="modal" data-target="contenttypes" id="update-me">
                        <span class='glyphicon glyphicon-edit'></span> Update
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>
<!--End of Edit Modal-->
@endsection @section('scripts')
<script>
    $(window).on('load', function () {
        $('#roleTable').removeAttr('style');
    })

</script>
<script type="text/javascript" src="{{ asset('js/calls/modals.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/calls/calls.js') }}"></script>
@endsection
