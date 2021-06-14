@extends('layouts.app')

@section('content')
<div class="container report-details" id="hotline-report-create">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                @include('partials.errors')
            </div>
            
            <form method="post" action="{{ route('save-helpline') }}" id="submit-form" class="form-horizontal">

                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="pull-left">HOTLINE - New Report</h4>
                        <div class="pull-right form-actions">
                            <a href="" class="btn btn-default" data-toggle="modal" data-target="#myModal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
                            @if (GroupPermission::usercan('create','hotline'))
                            {{--  <input type="submit" name="submit" value="Save & Exit" form="submit-form" class="btn btn-primary">  --}}
                            <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Save & Exit
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <!-- <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Modal Header</h4>
                                </div> -->
                                <div class="modal-body">
                                    <p>Are you sure you want to leave this page? Any changes will be lost.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <a class="btn btn-primary" href="{{ URL::previous() }}">Yes</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!------------------>
                        <!-- User profile -->
                        <!------------------>
                        <fieldset>
                            <legend>User profile</legend>

                            <fieldset class="form-group">
                                <!-- Report Name -->
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <!-- Report Surname -->
                                <label for="surname" class="col-sm-2 control-label">Surname</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="surname">
                                </div>
                            </fieldset>
                            <fieldset class="form-group">
                                <!-- Report Email -->
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-4">
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <!-- Report Phone -->
                                <label for="phone" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="phone">
                                </div>
                            </fieldset>
                            <fieldset class="form-group">
                                <!-- Report Gender -->
                                <label for="gender" class="col-sm-2 control-label">Gender</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="gender">
                                        <option value="0" selected disabled>Select an option...</option>
                                        <option value="">Not Provided</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <!-- Report Age -->
                                <label for="age" class="col-sm-2 control-label">Age</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="age">
                                        <option value="0" selected disabled>Select an option...</option>
                                        <option value="" >Not Provided</option>
                                        <option value="5-11">5-11 years</option>
                                        <option value="12-18">12-18 years</option>
                                        <option value="18+">18+</option>
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset class="form-group">
                                <!-- Report User Role -->
                                <label for="report_role" class="col-sm-2 control-label">User role</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="report_role">
                                        <option value="0" selected disabled>Select an option...</option>
                                        <option value="" >Not Provided</option>
                                        @foreach($report_roles as $report_role)
                                        <option value={{ $report_role->name }}>{{ $report_role->display_name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Report Contact Method -->
                                <label for="submission_type" class="col-sm-2 control-label">Contact method *</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="submission_type" required>
                                        <option value="" selected disabled>Select an option...</option>
                                        @foreach($submission_types as $submission_type)
                                        <option value="{{ $submission_type->name }}">{{ $submission_type->display_name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                        </fieldset>

                        <!------------------------>
                        <!-- Issue description  -->
                        <!------------------------>
                        <fieldset>
                            <legend>Report description</legend>
                            <!-- Report Resource Type -->
                            <fieldset class="form-group">
                                <label for="resource_type" class="col-sm-2 control-label">Resource Type *</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="resource_type" required>
                                        <option value="" selected disabled>Select an option...</option>
                                        @foreach($resource_types->sortBy('display_name_en') as $resource_type)
                                            <option value={{ $resource_type->name }}>{{ $resource_type->display_name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="resource_url" class="col-sm-2 control-label">Resource URL</label>
                                <div class="col-sm-4">
                                    <input type="url" class="form-control" name="resource_url">
                                </div>
                            </fieldset>
                            <!-- Report Content Type -->
                            <fieldset class="form-group">
                                <label for="content_type" class="col-sm-2 control-label">Content Type *</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="content_type" required>
                                        <option value="" selected disabled>Select an option...</option>
                                        @foreach($content_types->sortBy('display_name_en') as $content_type)
                                            @if ($content_type->is_for == 'hotline')
                                                <option value={{ $content_type->name }}>{{ $content_type->display_name_en }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            <!-- Report User Comments -->
                            <fieldset class="form-group">
                                <label for="comments" class="col-sm-2 control-label">User comments</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="comments"></textarea>
                                </div>
                            </fieldset>
                        </fieldset>

                        <!---------------------->
                        <!-- Operator actions -->
                        <!---------------------->
                        <fieldset>
                            <legend>Operator actions</legend>
                            <fieldset class="form-group">
                                <!-- Report Opened by operator -->
                                <label for="user_opened" class="col-sm-2 control-label">Opened by operator</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="{{Auth::user()->name}}" disabled>
                                    <input type="hidden" value="{{Auth::id()}}" name="user_opened">
                                </div>
                                <!-- Report Forward to operator -->
                                <label for="user_assigned" class="col-sm-2 control-label">Forward to operator</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="user_assigned">
                                        <option value="0" selected disabled>Select an option...</option>
                                        <option value="">No one</option>
                                        @foreach($users as $user)
                                            {{-- @if($user->hasRole(['operator']))
                                                <option value="{{ $user->id }}"> {{ $user->name }}</option>
                                            @endif --}}
                                        @endforeach


                                    </select>
                                </div>
                            </fieldset>
                            <!-- Report Priority -->
                            <fieldset class="form-group">
                                <label for="priority" class="col-sm-2 control-label">Priority</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="priority">
                                        @foreach($priorities as $priority)
                                        <option value="{{ $priority->name }}" class="{{ $priority->name }}-priority">{{ $priority->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            <!-- Report Referenced by -->
                            <fieldset class="form-group">
                                <label for="reference_by" class="col-sm-2 control-label">Reference by</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="reference_by">
                                        <option value="0" selected disabled>Select an option...</option>
                                        @foreach($references_by as $reference_by)
                                        <option value="{{ $reference_by->name }}">{{ $reference_by->display_name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            <!-- Report Informed -->
                            <fieldset class="form-group">
                                <label for="reference_to" class="col-sm-2 control-label">Reference to</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="reference_to">
                                        <option value="0" selected disabled>Select an option...</option>
                                        @foreach($references_to as $reference_to)
                                        <option value="{{ $reference_to->name }}">{{ $reference_to->display_name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            <!-- Report Actions -->
                            <fieldset class="form-group">
                                <label for="actions" class="col-sm-2 control-label">Actions</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" name="actions"> </textarea>
                                </div>
                            </fieldset>
                            <!-- Report Status -->
                            <fieldset class="form-group">
                                <label for="status" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="status">
                                        @foreach($status as $onestatus)
                                            @if ($onestatus->name != "New")
                                                <option value="{{ $onestatus->name }}" >{{$onestatus->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            <!-- Report Date Time of Call -->
                            <fieldset class="form-group">
                                <label for="status" class="col-sm-2 control-label">Reported Date</label>
                                <div class="col-sm-4">
                                    <label for="call_time">Call Date </label>
                                    <input name="call_time" type='text' id="call_time" class="form-control form-inline" value="{{date('d/m/Y H:i')}}"   />
                                </div>
                            </fieldset>
                            <fieldset class="form-group">
                                <!-- Report Related Id -->
                                <label for="RelatedId" class="col-sm-2 control-label">Related Hotline/HelpLine ID </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value=""  name="insident_reference_id" >
                                </div>
                            </fieldset>

                        </fieldset>

                        <div class="help-block"><b>* Required fields.</b></div>

                        {{-- When new HOTLINE report is created and submitted by operator --}}
                        <input type="hidden" name="is_it_hotline" value="true">
                        <input type="hidden" name="submitted_by_operator" value="true">
        
                        {{ csrf_field() }}
        
                    </div> <!-- end <div class="panel-body"> -->
                </div> <!-- end <div class="panel panel-default"> -->
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
