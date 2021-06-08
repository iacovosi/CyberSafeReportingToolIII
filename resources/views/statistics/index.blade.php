@extends('layouts.app') @section('content')

<div class="container">

    @if(GroupPermission::usercan('view','statistics'))

    <!-------------->
    <!-- FILTERS  -->
    <!-------------->
    <div class="panel panel-default" >
        <div class="panel-body">
            <form action="{{ route('statistics.store') }} " class="form-inline results-filters" method="post" id="submit-form">

                <i class="fa fa-filter" aria-hidden="true"> Filters: </i>

                <div class="form-group">
                    <label for="filterStatus">Status</label>
                    <select name="filterStatus" class="form-control">
                        {{--  <option value="default" disabled>Select status</option>  --}}
                        <option value="*">ALL</option>
                        @foreach($status as $astatus)
                            <option value="{{ $astatus->name }}"  @if (old('filterStatus') == $astatus->name) selected  @endif  > {{ $astatus->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="fromDate">From</label>
                    <input name="fromDate" type='date' class="form-control form-inline" value="{{ old('fromDate') }}"   />
                </div>
                <div class="form-group">
                    <label for="toDate">To</label>
                    <input name="toDate" type='date' class="form-control form-inline" value="{{ old('toDate') }}" />
                </div>

                {{ csrf_field() }}

                <div class="pull-right">
                    <button type="submit" class="btn btn-success">
                            <i class="fa fa-search"></i> Search (ALL)
                    </button>
                    <button type="submit" class="btn btn-primary" name="exportThis" value="toExcel">
                            <i class="fa fa-file-excel-o"></i> Export (ALL)
                    </button>                    
                </div>
            </form>
        </div> 
    </div> <!-- END .panel -->

        <div class="panel panel-default" >
            <div class="panel-body">
            Quering Result Records:
            </div>
        </div>
    <!---------------->
    <!-- STATISTICS -->
    <!---------------->
    @include('partials.errors')
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    {{-- <h4 class="pull-left"><i class="fa fa-file-text-o"></i>  Reports Statistics (Total of all Records {{ count($statistics)  }})</h4> <!-- $statistics->total() --> --}}
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-hover" id="DataTableStatistics" style="">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Operator(s)</th>
                                    <th>Service</th>
                                    <th>Resource Type</th>
                                    <th>Content Type</th>
                                    <th>Age</th>
                                    {{--  <th>Gender</th>  --}}
                                    {{--  <th>Report role</th>  --}}
                                    {{--  <th>Reference by</th>  --}}
                                    {{--  <th>Reference to</th>  --}}
                                    <th>Operator actions</th>
                                    {{--  <th>Priority</th>  --}}
                                    <th>Contact method</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    {{--  <th>Last Updated</th>  --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statistics as $indexKey => $report)
                                 @if(isset($report) && !empty($report))
                                <tr>
                                <!-- possible bug $report->relatedToHelpLine->log, when you delete report the view breaks-->
                                <!-- it is the relatedToHelpLine value -->
                                <!-- Error: Trying to get property 'log' of non-object -->
                                    <td><span class="top" title="{{$report->relatedToHelpLine->log}}"> {{ $report->tracking_id }}</span></td>
                                    <td>
                                        @if(isset($report->firstResponderStats)) 
                                            <?php  
                                                $words = explode(" ", $report->firstResponderStats->name);
                                                $firstname = $words[0];
                                            ?>
                                            <span class="top" title="{{$report->firstResponderStats->name}}">{{$firstname}}</span>
                                            @else
                                                <span class="top" title="Unassigned"> -> Unassigned</span>
                                        @endif 
                                        @if(isset($report->lastResponderStats)) 
                                            <?php  
                                                $words = explode(" ", $report->lastResponderStats->name);
                                                $firstname = $words[0];
                                            ?>                                    
                                            <span class="top" title="{{$report->lastResponderStats->name}}"> -> {{$firstname}}</span>
                                            @else
                                                <span class="top" title="Unassigned"> -> Unassigned</span>
                                        @endif
                                            @if($report->forwarded=="true")
                                                (Forwarded from >@if($report->is_it_hotline == 'true') Helpline @else Hotline @endif))
                                            @endif
                                    </td> 
                                    <td>@if($report->is_it_hotline == 'true') Hotline @else Helpline @endif</td>
                                    <td>
                                        {{--  {{ $report->resourcetype }}  --}}
                                        @foreach($resource_types as $resource_type)
                                            @if( $report->resource_type == $resource_type->name ) {{ $resource_type->display_name_en }} @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($content_types as $content_type)
                                            @if( $report->content_type == $content_type->name ) {{ $content_type->display_name_en }} @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $report->age }}</td>
                                    {{--  <td>{{ $report->gender }}</td>  --}}
                                    {{--  <td>
                                        @foreach($report_roles as $report_role)
                                            @if( $report->$report_role == $report_role->name ) {{ $report_role->display_name_en }} @endif
                                        @endforeach
                                    </td>  --}}
                                    {{--  <td>{{ $report->reference_by }}</td>  --}}
                                    {{--  <td>{{ $report->reference_to }}</td>  --}}
                                    <td>{{ str_limit($report->actions, $limit = 40, $end = '...') }}</td>
                                    {{--  <td>{{ $report->priority }}</td>  --}}
                                    <td>
                                        {{--  {{ $report->submission_type }}  --}}
                                        @foreach($submission_types as $submission_type)
                                            @if($report->submission_type == $submission_type->name ) {{ $submission_type->display_name_en }} @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $report->status }}</td>
                                    {{--  <td>{{ $report->created_at }}</td>  --}}
                                    <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $report->created_at)->diffForHumans() }}</td>
                                    {{--  <td>{{ $report->updated_at }}</td>  --}}
                                    {{--  <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $report->updated_at)->diffForHumans() }}</td>                                      --}}
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- END .panel-body -->

                <div class="panel-footer">
                    {{--  {{ $statistics->appends(Request::only('filterStatus'))->render() }}  --}}
                    {{--  {{ $statistics->appends(Request::only('page'))->render() }} --}}
                </div> <!-- END .panel-footer -->

            </div> <!-- END .panel -->
        </div>
    </div> <!-- END STATISTICS -->

    @endif
</div>

<div class="container">
    <div class="panel panel-default" >
    <div class="panel-heading clearfix">
        <h4 class="pull-left"><i class="fa fa-bar-chart" aria-hidden="true"></i> General Graphs and Charts</h4>
    </div>
        <div class="panel-body">
            <div class="col-sm-6">
            {!! $Helpline_types->container() !!}
            </div>                           
            <div class="col-sm-6">
            {!! $weekly_bar->container() !!}
            </div>
            {!! $weekly_bar->script() !!}
            {!! $Helpline_types->script() !!}    
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
</script>

@endsection




{{--  <div class="row">
                    <div class="col-sm-2">
                        @if($referals)
                        <div class="form-group label-floating">
                            <label class="control-label">Informed:</label>
                            <select class="js-example-basic-multiple form-control" name="referal[]" multiple="multiple">
                                @foreach ($referals as $referal)
                                <option value="{{ $referal->name }}">{{ $referal->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-2">
                        @if($references)
                        <div class="form-group label-floating">
                            <label class="control-label">Referenced by:</label>
                            <select class="js-example-basic-multiple form-control" name="reference[]" multiple="multiple">
                                @foreach ($references as $reference)
                                <option value="{{ $reference->name }}">{{ $reference->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-2">
                        @if($actionsTaken)
                        <div class="form-group label-floating">
                            <label class="control-label">Actions:</label>
                            <select class="js-example-basic-multiple form-control" name="actions[]" multiple="multiple">
                                @foreach ($actionsTaken as $action)
                                <option value="{{ $action->name }}">{{ $action->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                </div>  --}}
