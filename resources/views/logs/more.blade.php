@extends('layouts.app')

@section('content')
    <div class="container report-details" id="log-report-edit">

        <div class="row">
            <div class="col-md-12">

                <form>
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h4 class="pull-left">Report Log</h4>
                            <div class="pull-right form-actions">
                                <a href="{{ route('helplinesLogController.timeline', $log->reference_id) }}" class="btn btn-info">Back</a>
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
                                        HIDDEN
                                    </div>
                                    <!-- Report Surname -->
                                    <label for="surname" class="col-sm-2 control-label">Surname</label>
                                    <div class="col-sm-4">
                                        HIDDEN
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Email -->
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        HIDDEN
                                    </div>
                                    <!-- Report Phone -->
                                    <label for="phone" class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-4">
                                        HIDDEN
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Gender -->
                                    <label for="gender" class="col-sm-2 control-label">Gender</label>
                                    <div class="col-sm-4">
                                        {{$log->gender ? $log->gender : 'Not provided'}}
                                    </div>
                                    <!-- Report Age -->
                                    <label for="age" class="col-sm-2 control-label">Age</label>
                                    <div class="col-sm-4">
                                        {{$log->age ? $log->age : 'Not provided'}}
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report User Role -->
                                    <label for="report_role" class="col-sm-2 control-label">User role</label>
                                    <div class="col-sm-4">
                                        {{$log->report_role ? $log->report_role : 'Not provided'}}
                                    </div>
                                    <!-- Report Contact Method -->
                                    <label for="submission_type" class="col-sm-2 control-label">Contact method</label>
                                    <div class="col-sm-4">
                                        {{$log->submission_type}}
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
                                    <label for="resource_type" class="col-sm-2 control-label">Resource Type</label>
                                    <div class="col-sm-4">
                                        {{$log->resource_type}}
                                    </div>
                                    <!-- Website url -->
                                    <label for="resource_url" class="col-sm-2 control-label">Website URL</label>
                                    <div class="col-sm-4">
                                        HIDDEN
                                    </div>

                            </fieldset>
                                <!-- Report Content Type -->
                                <fieldset class="form-group">
                                    <label for="content_type" class="col-sm-2 control-label">Content Type</label>
                                    <div class="col-sm-4">
                                        {{$log->content_type}}
                                    </div>
                                </fieldset>
                                <!-- Report User Comments -->
                                <fieldset class="form-group">
                                    <label for="comments" class="col-sm-2 control-label">User comments</label>
                                    <div class="col-sm-10">
                                        @if($log->comments == null)
                                            <?php $comments = "Not provided."; ?>
                                        @else
                                            <?php $comments = Crypt::decrypt($log->comments); ?>
                                        @endif
                                        <textarea class="form-control" name="comments" rows="3" disabled>{{ $comments  }}</textarea>
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
                                        {{$log->firstOpened ? $log->firstOpened->name : 'None' }}
                                    </div>
                                    <!-- Report Forward to operator -->
                                    <label for="user_assigned" class="col-sm-2 control-label">Assigned to</label>
                                    <div class="col-sm-4">
                                        {{$log->assignedTo ? $log->assignedTo->name : 'None' }}
                                    </div>
                                </fieldset>
                                <!-- Report Priority -->
                                <fieldset class="form-group">
                                    <label for="priority" class="col-sm-2 control-label">Priority</label>
                                    <div class="col-sm-4">
                                        {{ $log->priority }}
                                    </div>
                                </fieldset>
                                <!-- Report Referenced by -->
                                <fieldset class="form-group">
                                    <label for="reference_by" class="col-sm-2 control-label">Reference by</label>
                                    <div class="col-sm-4">
                                        {{ $log->reference_by?$log->reference_by: 'Not Provided' }}
                                    </div>
                                </fieldset>
                                <!-- Report Informed -->
                                <fieldset class="form-group">
                                    <label for="reference_to" class="col-sm-2 control-label">Reference to</label>
                                    <div class="col-sm-4">
                                        {{ $log->reference_to?$log->reference_to: 'Not Provided' }}
                                    </div>
                                </fieldset>
                                <!-- Report Actions -->
                                <fieldset class="form-group">
                                    <label for="actions" class="col-sm-2 control-label">Actions</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="actions" rows="3"
                                                  disabled> {{ $log->actions}}</textarea>
                                    </div>
                                </fieldset>
                                <!-- Report Status -->
                                <fieldset class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-4">
                                        {{$log->status}}
                                    </div>
                                </fieldset>

                                <!-- Report Date Time of Call -->
                                <fieldset class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Reported Date</label>
                                    <div class="col-sm-4">
                                        <label for="call_time">Call Date </label><br>
                                        {{ $log->call_time }}
                                    </div>
                                </fieldset>
                            </fieldset>
                            <!---------------------->
                            <!-- Manager actions -->
                            <!---------------------->
                            <fieldset>
                                <legend>Manager comments</legend>
                                <!-- Report User Comments -->
                                <fieldset class="form-group">
                                    <label for="comments" class="col-sm-2 control-label">comments </label>
                                    <div class="col-sm-10">
                                    
                                    <textarea class="form-control" name="manager_comments" rows="3" disabled>{{$log->manager_comments?strip_tags(Crypt::decrypt($log->manager_comments)):''}}</textarea>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Related Id -->
                                    <label for="RelatedId" class="col-sm-2 control-label">Related Hotline/HelpLine
                                        ID </label>
                                    <div class="col-sm-4">
                                        {{ $log->insident_reference_id? $log->insident_reference_id: 'Not provided' }}
                                    </div>
                                </fieldset>
                            </fieldset>

                        </div> <!-- end <div class="panel-body"> -->
                    </div> <!-- end <div class="panel panel-default"> -->

                </form>

            </div>
        </div>
    </div>
@endsection