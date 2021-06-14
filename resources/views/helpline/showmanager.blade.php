@extends('layouts.app')

@section('content')
    <div class="container report-details" id="helpline-report-edit">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    @include('partials.errors')
                </div>
                <form method="POST" action="{{route('edit-helpline-manager',['id' => $helpline->id ])}}" id="submit-form"
                      class="form-horizontal">
                      @csrf
                      @method('PATCH')
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h4 class="pull-left">HELPLINE - Report ID : # {{ $helpline->id }}</h4>
                            <div class="pull-right form-actions">
                            <a href="{{route('helpline.move-hotline',['id' => $helpline->id])}}" class="btn btn-danger"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Forward to HOTLINE</a>
                                <a href="" class="btn btn-default" data-toggle="modal" data-target="#myModal"><i
                                            class="fa fa-times" aria-hidden="true"></i> Cancel</a>
                                @role('manager')
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save & Exit
                                    </button>
                                @endrole
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

                        <!-- When passing data to controler with "request->all()", "is_it_hotline" value is needed -->
                        <input type="hidden" name="id" value="{{  $helpline->id  }}">
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
                                        @if($helpline->name == null)
                                            <input type="text" class="form-control" value="" placeholder="Not provided"
                                                   disabled>
                                        @else
                                            <input type="text" class="form-control" value="{{ $helpline->name }}"
                                                   disabled>
                                        @endif
                                    </div>
                                    <!-- Report Surname -->
                                    <label for="surname" class="col-sm-2 control-label">Surname</label>
                                    <div class="col-sm-4">
                                        @if($helpline->surname == null)
                                            <input type="text" class="form-control" value="" placeholder="Not provided"
                                                   disabled>
                                        @else
                                            <input type="text" class="form-control" value="{{ $helpline->surname }}"
                                                   disabled>
                                        @endif
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Email -->
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        @if($helpline->email == null)
                                            <input type="text" class="form-control" value="" placeholder="Not provided"
                                                   disabled>
                                        @else
                                            <input type="text" class="form-control" value="{{ $helpline->email }}"
                                                   disabled>
                                        @endif
                                    </div>
                                    <!-- Report Phone -->
                                    <label for="phone" class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-4">
                                        @if($helpline->phone == null)
                                            <input type="text" class="form-control" value="" placeholder="Not provided"
                                                   disabled>
                                        @else
                                            <input type="text" class="form-control" value="{{ $helpline->phone }}"
                                                   disabled>
                                        @endif
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Gender -->
                                    <label for="gender" class="col-sm-2 control-label">Gender</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="gender" disabled>
                                            <option value="0" @if($helpline->age == "0") selected @endif disabled>Select
                                                an option...
                                            </option>
                                            <option value="" @if($helpline->gender == null) selected @endif>Not
                                                Provided
                                            </option>
                                            <option value="male" @if($helpline->gender == 'male') selected @endif>Male
                                            </option>
                                            <option value="female" @if($helpline->gender == 'female') selected @endif>
                                                Female
                                            </option>
                                        </select>
                                    </div>
                                    <!-- Report Age -->
                                    <label for="age" class="col-sm-2 control-label">Age</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="age" name="age" disabled>
                                            <option value="0" @if($helpline->age == "0") selected @endif disabled>Select
                                                an option...
                                            </option>
                                            <option value="" @if($helpline->age == null) selected @endif>Not Provided
                                            </option>
                                            <option value="5-11" @if($helpline->age == '5-11') selected @endif>5-11
                                                years
                                            </option>
                                            <option value="12-18" @if($helpline->age == '12-18') selected @endif>12-18
                                                years
                                            </option>
                                            <option value="18+" @if($helpline->age == '18+') selected @endif>18+
                                            </option>
                                        </select>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report User Role -->
                                    <label for="report_role" class="col-sm-2 control-label">User role</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="report_role" disabled>
                                            <option value="0" @if($helpline->user_role == "0") selected @endif disabled>
                                                Select an option...
                                            </option>
                                            <option value="" @if($helpline->user_role == null) selected @endif>Not
                                                Provided
                                            </option>
                                            @foreach($report_roles as $report_role)
                                                <option value="{{ $report_role->name }}"
                                                        @if($helpline->report_role == $report_role->name ) selected @endif> {{ $report_role->display_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Report Contact Method -->
                                    <label for="submission_type" class="col-sm-2 control-label">Contact method</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="submission_type" disabled>
                                            <option value="0" @if($helpline->submission_type == "0") selected
                                                    @endif disabled>Select an option...
                                            </option>
                                            @foreach($submission_types as $submission_type)
                                                <option value="{{ $submission_type->name }}"
                                                        @if($helpline->submission_type == $submission_type->name ) selected @endif> {{ $submission_type->display_name_en }}</option>
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
                                    <label for="resource_type" class="col-sm-2 control-label">Resource Type</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="resource_type" disabled>
                                            @foreach($resource_types->sortBy('display_name_en') as $resource_type)
                                                <option value="{{ $resource_type->name }}"
                                                        @if( $helpline->resource_type == $resource_type->name ) selected @endif>{{ $resource_type->display_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Website url -->
                                    <label for="resource_url" class="col-sm-2 control-label">Website URL</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="{{ $helpline->resource_url }}"
                                               name="resource_url" disabled>
                                    </div>

                                </fieldset>
                                <!-- Report Content Type -->
                                <fieldset class="form-group">
                                    <label for="content_type" class="col-sm-2 control-label">Content Type</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="content_type" disabled>
                                            @foreach($content_types->sortBy('display_name_en') as $content_type)
                                                @if ($content_type->is_for == 'helpline')
                                                    <option value="{{ $content_type->name }}"
                                                            @if( $helpline->content_type == $content_type->name ) selected @endif>{{ $content_type->display_name_en }}</option>
                                                @endif
                                            @endforeach
                                            x </select>
                                    </div>
                                </fieldset>
                                <!-- Report User Comments -->
                                <fieldset class="form-group">
                                    <label for="comments" class="col-sm-2 control-label">User comments</label>
                                    <div class="col-sm-10">
                                        @if($helpline->comments == null)
                                            <?php $comments = "Not provided."; ?>
                                        @else
                                            <?php $comments = Crypt::decrypt($helpline->comments); ?>
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
                                        @if($helpline->firstResponder == null)
                                                <input type="text" class="form-control" value="No one" readonly></option>
                                        @else
                                            <input type="text" class="form-control"
                                               value="{{$helpline->firstResponder->name}}" readonly>
                                        @endif
                                    </div>
                                    <!-- Report Forward to operator -->
                                    <label for="user_assigned" class="col-sm-2 control-label">Forward to
                                        operator</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="user_assigned" disabled>
                                            @if($helpline->user_assigned == null)
                                                <option value selected>No one</option>
                                            @endif
                                            @foreach($users as $user)
                                                {{-- @if($user->hasRole(['operator']))
                                                    <option value="{{ $user->id }}"
                                                            @if ($helpline->user_assigned == $user->id) selected @endif>{{ $user->name }}</option>
                                                @endif --}}
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Priority -->
                                <fieldset class="form-group">
                                    <label for="priority" class="col-sm-2 control-label">Priority</label>
                                    <div class="col-sm-4">
                                        <select class="form-control {{ $helpline->priority }}-priority" name="priority"
                                                disabled>
                                            @foreach($priorities as $priority)
                                                <option value="{{ $priority->name }}"
                                                        class="{{ $priority->name }}-priority"
                                                        @if ($helpline->priority == $priority->name) selected @endif>{{ $priority->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Referenced by -->
                                <fieldset class="form-group">
                                    <label for="reference_by" class="col-sm-2 control-label">Reference by</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="reference_by" disabled>
                                            <option value="" disabled
                                                    @if($helpline->reference_by == null) selected @endif >Select an
                                                option...
                                            </option>
                                            @foreach($references_by as $reference_by)
                                                <option value="{{ $reference_by->name }}"
                                                        @if($helpline->reference_by == $reference_by->name) selected @endif>{{ $reference_by->display_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Informed -->
                                <fieldset class="form-group">
                                    <label for="reference_to" class="col-sm-2 control-label">Reference to</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="reference_to" disabled>
                                            <option value="" disabled
                                                    @if($helpline->reference_to == null) selected @endif>Select an
                                                option...
                                            </option>
                                            @foreach($references_to as $reference_to)
                                                <option value="{{ $reference_to->name }}"
                                                        @if($helpline->reference_to == $reference_to->name) selected @endif>{{ $reference_to->display_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Actions -->
                                @if (is_null(json_decode($helpline->actions)))
                                    <fieldset class="form-group">
                                    <label for="actions" class="col-sm-2 control-label">Actions</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" disabled rows="3">{{$helpline->actions}}</textarea>
                                    </div>
                                </fieldset>
                                @else

                                    @foreach (json_decode($helpline->actions) as $user_id => $actions)
                                        
                                            @if (User::find($user_id))
                                            <fieldset class="form-group">
                                                <label for="actions" class="col-sm-2 control-label">Actions <br> {{User::find($user_id)->name}} </label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" disabled rows="3">{{$actions}}</textarea>
                                                </div>
                                            </fieldset>
                                            @endif
                                            <br>
                                    @endforeach
                                @endif
                                <!-- Report Status -->
                                <fieldset class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="status" disabled>
                                            @foreach($status as $onestatus)
                                                @if ($onestatus->name != "New")
                                                    <option value="{{ $onestatus->name }}"
                                                            @if ($helpline->status == $onestatus->name) selected @endif >{{$onestatus->name }}</option>
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
                                        <input name="call_time" type='text' id="call_time"
                                               class="form-control form-inline" value="{{ $helpline->call_time }}"
                                               disabled/>
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
                                    @if($helpline->manager_comments == null) <?php $c= "Not Provided."; ?>
                                    @else <?php $c=Crypt::decrypt($helpline->manager_comments); ?> @endif
                                    <textarea class="form-control" name="manager_comments" rows="3">{{$c}}</textarea>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Related Id -->
                                    <label for="RelatedId" class="col-sm-2 control-label">Related Hotline/HelpLine
                                        ID </label>
                                    <div class="col-sm-4">
                                        @if($helpline->insident_reference_id == null)
                                            <input type="number"  class="form-control"
                                                   value=""
                                                   name="insident_reference_id">
                                        @else
                                            <input type="number" class="form-control"
                                                   value="{{ $helpline->insident_reference_id }}"
                                                   name="insident_reference_id">
                                            @if (isset($referenceidInfo['is_it_hotline']) && ($referenceidInfo['is_it_hotline']=="true"))
                                                @if(GroupPermission::usercan('view','hotline'))
                                                    <a href="{{route('hotline.show.manage',['id' => $helpline->insident_reference_id ])}}">Link
                                                        to HotLine</a>
                                                @else
                                                    Not Permission to View Hotline
                                                @endif
                                            @else
                                                @if(GroupPermission::usercan('view','helpline'))
                                                    <a href="{{route('show-helpline-manager',['id' => $helpline->insident_reference_id ])}}">Link
                                                        to Helpline</a>
                                                @else
                                                    Not Permission to View HelpLine
                                                @endif
                                            @endif
                                        @endif
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

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
            $('#call_time').datetimepicker({
                locale: 'en-gb'
            });
        });
    </script>
@endsection
