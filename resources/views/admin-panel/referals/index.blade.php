@extends('layouts.app') 

@section('links-scripts') 
@endsection 

@section('content')
<div class="container">
   
    @include('partials.info')
    
    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            <h4 class="pull-left"><i class="fa fa-file-text-o"></i> Reference to</h4>
            <div class="pull-right form-actions">
                @if(GroupPermission::usercan('create','content'))
                    <a href="#" class="add-modal btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> New
                    </a>
                @endif
            </div>            
        </div>

        <div class="panel-body">
            <table class="table table-striped table-hover table-condensed" id="roleTable" style="visibility: hidden;">
                <thead>
                    <tr>
                        <th valign="middle">#</th>
                        {{--  <th>ID</th>  --}}
                        <th>Value</th>
                        <th>English Name</th>
                        <th>English Description</th>
                        <th>Greek Name</th>
                        <th>Greek Description</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($referals) @foreach ($referals as $indexKey => $item)
                    <tr class="item{{$item->id}}">
                        <td class="col1">{{ $indexKey+1 }}</td>
                        {{--  <td>{{$item->id}}</td>  --}}
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            {{$item->display_name_en}}
                        </td>
                        <td>
                            {{ $item->description_en}}
                        </td>
                        <td>
                            {{ $item->display_name_gr }}
                        </td>
                        <td>
                            {{ $item->description_gr }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at)->diffForHumans() }}
                        </td>
                        <td style='white-space: nowrap'>
                            {{--  <button class="btn btn-success view-this"  data-name="{{ $item->name }}" data-display_name_gr="{{ $item->display_name_gr }}" data-display_name_en="{{ $item->display_name_en }}" data-description_gr="{{ $item->description_gr }}" data-description_en="{{ $item->description_en }}"><span class="glyphicon glyphicon-eye-open"></span>View</button>  --}}
                            <button class="btn btn-default update-this" 
                                    data-id="{{ $item->id }}" 
                                    data-name="{{ $item->name }}"
                                    data-display_name_gr="{{ $item->display_name_gr }}" 
                                    data-display_name_en="{{ $item->display_name_en }}" 
                                    data-description_gr="{{ $item->description_gr }}" 
                                    data-description_en="{{ $item->description_en }}">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                            </button>
                            <button class="btn btn-default" id="delete-this" 
                                    data-target="referals" 
                                    data-id="{{ $item->id }}"> 
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach @else
                    <p> There are not any permissions saved yet. Click Add new to create one.</p>
                    @endif
                </tbody>
            </table>
        </div> <!-- /.panel-body -->
    </div> <!-- /.panel panel-default -->
    
    @include('partials.errors')

</div>

<!-- Add Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form" role="form" id="submit-form">
                    <div class="form-group">
                        <label for="name">  Name:</label>
                        <input type="text" name="name" class="form-control" value="" id="name" placeholder="Name it..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="name"> English Name:</label>
                        <input type="text" name="display_name_en" class="form-control" value="" id="display_name_en" placeholder="Name it..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="name"> English Description:</label>
                        <input type="text" name="description_en" class="form-control" value="" id="description_en" placeholder="Name it..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="name">Ελληνικό όνομα:</label>
                        <input type="text" name="display_name_gr" class="form-control" value="" id="display_name_gr" placeholder="Ονομασία..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="name"> Greek Description:</label>
                        <input type="text" name="description_gr" class="form-control" value="" id="description_gr" placeholder="Name it..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary add" id="save-this" data-target="referals" data-dismiss="modal">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal-->
<div id="update-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit</h4>
            </div>
            <div class="modal-body">
                <form class="form" role="form" id="submit-form">
                    <div class="form-group">
                        <label for="name">  Name:</label>
                        <input type="text" name="name" class="form-control" value="" id="name" placeholder="Name it..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="name"> English Name:</label>
                        <input type="text" name="display_name_en" class="form-control" value="" id="display_name_en" placeholder="Name it..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="name"> English Description:</label>
                        <input type="text" name="description_en" class="form-control" value="" id="description_en" placeholder="Name it..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="name">Ελληνικό όνομα:</label>
                        <input type="text" name="display_name_gr" class="form-control" value="" id="display_name_gr" placeholder="Ονομασία..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="name"> Greek Description:</label>
                        <input type="text" name="description_gr" class="form-control" value="" id="description_gr" placeholder="Name it..">
                        <p class="errorTitle text-center alert alert-danger hidden"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary update-content" data-dismiss="modal" data-target="referals" id="update-me">
                    <span class='glyphicon glyphicon-edit'></span> Update
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection 

@section('scripts')
<script>
    $(window).on('load', function () {
        $('#roleTable').removeAttr('style');
    })

</script>
<script type="text/javascript" src="{{ asset('js/calls/modals.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/calls/calls.js') }}"></script>
@endsection
