@extends('layouts.app') 
    
    @section('content')

    <div class="container">

        <div class="panel panel-default" >
            <div class="panel-body">
                <form action="{{ route('helplinesLogController.index') }} " class="form-inline results-filters" method="GET" id="submit-form">

                    <i class="fa fa-filter" aria-hidden="true"> Filters: </i>

                    <div class="form-group">
                        <label for="filterStatus">Status</label>
                        <select name="filterStatus" class="form-control">
                            <option value="default" disabled>Select status</option> 
                            <option value="*">ALL</option>
                            @foreach($status as $astatus)
                            <option value="{{ $astatus->name }}"  @if (old('filterStatus') == $astatus->name) selected  @endif  > {{ $astatus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fromDate">From</label>
                        <input name="fromDate" type='date' class="form-control form-inline" value="{{ request()->get('fromDate')}}"   />
                    </div>
                    <div class="form-group">
                        <label for="toDate">To</label>
                        <input name="toDate" type='date' class="form-control form-inline" value="{{ request()->get('toDate')}}" />
                    </div>

                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i> Search
                        </button>                 
                    </div>
                </form>
            </div> 
        </div> <!-- END .panel -->
    </div>
    
    <div class="container">
        @include('partials.info')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="pull-left">Hotline/Helpline Logs</h4>
                    </div>
                    
                    
                    <div class="panel-body">
                        <div class="alert alert-info" role="alert">
                            
                            The table below illustrates all the reports as they are / were in their final form.
                        </div>
                        
                        <div class="table-responsive">
                            
                            <table class="table table-condensed table-striped table-hover" id="DataTableStatistics" style="">
                                
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Operator</th>
                                        <th>Last Assigned Operator</th>
                                        <th>Service</th>
                                        <th>Resource Type</th>
                                        <th>Content Type</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $key => $log)
                                    <tr>
                                        <td>{{$log->reference_id}}</td>
                                        <td>{{$log->firstOpened ? $log->firstOpened->name : 'None' }}</td>
                                        <td>{{$log->assignedTo ? $log->assignedTo->name : 'None' }}</td> 
                                        <td>{{$log->is_it_hotline ? 'Hotline': 'Helpline'}}</td>
                                        <td>{{$log->resource_type ? $log->resource_type: 'None'}}</td>
                                        <td>{{$log->content_type ? $log->content_type: 'None'}}</td>
                                        <td>{{$log->status ? $log->status: 'None'}}</td>
                                        <td>{{$log->created_at ? $log->created_at: 'None'}}</td>
                                        <td><a class="btn btn-primary" href="{{route('helplinesLogController.timeline', $log->reference_id)}}">View History</a>
                                        </td>
                                        <td>
                                            <form id="delete-entry" method="POST" action="{{route('helplinesLogController.destroy', $log->reference_id)}}">
                                                                                        
                                                  {{ csrf_field() }}
                                                  {{ method_field('DELETE') }}

                                                
                                              </form>

                                              @if(GroupPermission::usercan('delete','logs'))
                                                <button onclick="confirm_delete()" class="btn btn-danger">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                              @endif
                                        </td>
                                        <td>
                                            <form autocomplete="off">
                                                <input type="checkbox" class="delete-check" id="{{$log->reference_id}}" >
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if(GroupPermission::usercan('delete','logs'))
                            <button onclick="confirm_mass_delete()" class="btn btn-danger">
                                <i class="fa fa-trash-o" aria-hidden="true"> Selected</i>
                            </button>
                        @endif                   
                    </div>
                    
                </div>    
            </div>
        </div>
    </div> 
    @endsection

@section('scripts')

<script type="text/javascript" src="{{ asset('js/calls/modals.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/calls/calls.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
        $('#DataTableStatistics').DataTable( {
        dom: 'lBfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
            "language": {
                "search": "Result Search of returned Records:"
            }
    } );
    });

    function confirm_delete(){
        if (confirm('You are about to permanently delete this log entry. Are you sure?')){
            $('#delete-entry').submit()
        }
    }

    function confirm_mass_delete(){
        const selected_ids = {}
        if (confirm('You are about to permanently delete all selected log entries. Are you sure?')){
            $('.delete-check:checkbox:checked').each(function(index) {
                selected_ids[index] = parseInt($(this).attr("id"))
            })

            $.ajax({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}",
                },
                url: '{{route('helplinesLogController.mass_destroy')}}',
                type: 'DELETE',
                dataType: "json",
                data: {
                    selected_ids
                },
                success: function(result) {
                    location.reload();
                },
                error: function(result){
                    // console.log(result.responseJSON);
                }
            });
        }

    }
</script>

@endsection
