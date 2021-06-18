@extends('layouts.app')

@section('content')
    <div class="container report-details" id="fakenews-report-edit">

        <div class="row">
            <div class="col-md-12">

                <form method="post" action="{{ route('save-fakenews') }}" id="submit-form" class="form-horizontal" enctype = 'multipart/form-data'>
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h4 class="pull-left">FAKENEWS - New Report</h4>
                            <div class="pull-right form-actions">
                                @include('partials.errors')
                                <a href="" class="btn btn-default" data-toggle="modal" data-target="#myModal"><i
                                            class="fa fa-times" aria-hidden="true"></i> Cancel</a>
                                @if (GroupPermission::usercan('edit','fakenews'))
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
                                            <input type="text" class="form-control" value="" name = 'name'>
                                    </div>
                                    <!-- Report Surname -->
                                    <label for="surname" class="col-sm-2 control-label">Surname</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="" name = 'surname'>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Email -->
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="" name = 'email'>
                                    </div>
                                    <!-- Report Phone -->
                                    <label for="phone" class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" value="" name = 'phone'>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Gender -->
                                    <label for="gender" class="col-sm-2 control-label">Gender</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="gender" placeholder = 'Plaese select a choice...'>
                                            <option value="" disabled selected>Choose a gender...</option>
                                            <option value="male">
                                                Male
                                            </option>
                                            <option value="female">
                                                Female
                                            </option>
                                        </select>
                                    </div>
                                    <!-- Report Age -->
                                    <label for="age" class="col-sm-2 control-label">Age</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="age" name="age">
                                            <option value="" disabled selected>Choose an age group...</option>
                                            <option value="5-11">5-11
                                                years
                                            </option>
                                            <option value="12-18" >12-18
                                                years
                                            </option>
                                            <option value="18+">18+
                                            </option>
                                        </select>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report User Role -->
                                    <label for="report_role" class="col-sm-2 control-label">User role</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="report_role">
                                            <option value="" disabled selected>Choose a user role...</option>
                                            @foreach($report_roles as $report_role)
                                                <option value="{{ $report_role->name }}">
                                                {{ $report_role->display_name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Report Contact Method -->
                                    <label for="submission_type" class="col-sm-2 control-label">Contact method</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="submission_type" required>
                                            <option value="" disabled selected>Choose a contact method...</option>
                                            @foreach($submission_types as $submission_type)
                                                <option value="{{ $submission_type->name }}"> 
                                                {{ $submission_type->display_name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                            </fieldset>

                            <!------------------------>
                            <!-- Issue description  -->
                            <!------------------------>
                            <fieldset>
                                <legend>Report general description</legend>
                                <!-- Report Resource Type -->
                                <fieldset class="form-group">
                                    <label for="fakenews_source_type" class="col-sm-2 control-label">Fakenews Source Type <i>(Note shows up where relevant information would be for your type)</i></label>
                                    <div class="col-sm-4">
                                        <select class = "form-control" name = "fakenews_source_type" id = "fakenews_source_type">
                                            <option value="" disabled selected>Choose an source type...</option>
                                            @foreach($fakenews_source_type->sortBy('typename_en') as $source_type)
                                                <option value="{{ $source_type->typename }}">
                                                {{ $source_type->typename_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- publication date -->
                                    <label for="publication_date" class="col-sm-2 control-label" >Publication Date</label>
                                    <div class="col-sm-4">
                                            <input type="date" class="form-control" value="" 
                                            name="publication_date" required>
                                    </div>
                                </fieldset>
                                <!-- Programme time -->
                                <fieldset class="form-group">
                                <label class="col-sm-2 control-label"></label>   
                                    <div class="col-sm-4">
                                    <imput hidden></input>
                                    </div>
                                <label for="publication_time" class="col-sm-2 control-label">Publication Time</label>   
                                    <div class="col-sm-4">
                                        <input type="time" class="form-control" value="" 
                                        name="publication_time">
                                    </div>
                                </fieldset>
                                <!-- Report User Comments -->
                                <fieldset class="form-group">
                                    <label for="comments" class="col-sm-2 control-label">User comments</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="comments" rows="3"></textarea>
                                    </div>
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="int_sellect" class="ping"> <h3>***RELEVANT INFORMATION HERE***</h3></div>Internet source description </legend>
                                    <fieldset class="form-group">
                                        <!-- Website url -->
                                        <label for="source_url" class="col-sm-2 control-label">Website URL</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value=""
                                                    name="source_url" id ='source_url'>
                                        </div>
                                        <!-- News Title -->
                                        <label for="title" class="col-sm-2 control-label">News Title</label>   
                                        <div class="col-sm-4">
                                                <input type="text" class="form-control" value="" 
                                                name="title" id ='title'>
                                        </div>
                                    </fieldset>
                                    <!--Full/Part of Source article/news-->
                                    <fieldset class="form-group">
                                        <label for="source_document" class="col-sm-2 control-label">Source Document</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="source_document" rows="3" id ='source_document'></textarea>
                                        </div>
                                    </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="tv_sellect" class="ping"> <h3>***RELEVANT INFORMATION HERE***</h3></div>TV source description</legend>
                                    <fieldset class="form-group">
                                        <!-- Channel title -->
                                        <label for="tv_channel" class="col-sm-2 control-label">Channel Title</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value=""
                                                    name="tv_channel" id ='tv_channel'>
                                        </div>
                                        <!-- Programme title -->
                                        <label for="tv_prog_title" class="col-sm-2 control-label">Programme Title</label>   
                                        <div class="col-sm-4">
                                                <input type="text" class="form-control" value="" 
                                                name="tv_prog_title" id ='tv_prog_title'>
                                        </div>
                                    </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="radio_sellect" class="ping"> <h3>***RELEVANT INFORMATION HERE***</h3></div>Radio source description</legend>
                                <fieldset class="form-group">
                                    <!-- Radio_station -->
                                    <label for="radio_station" class="col-sm-2 control-label">Radio Station Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="" name="radio_station" id = 'radio_station'>
                                    </div>
                                    <!-- Radio station frequency -->
                                    <label for="radio_freq" class="col-sm-2 control-label">Radio Station Frequency [MHz]</label>   
                                    <div class="col-sm-4">
                                            <input type="text" class="form-control" value="" name="radio_freq" id = 'radio_freq'>
                                    </div>
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="newspaper_sellect" class="ping">  <h3>***RELEVANT INFORMATION HERE***</h3></div>Newspaper source description</legend>
                                <fieldset class="form-group">
                                    <!-- Newspaper name -->
                                    <label for="newspaper_name" class="col-sm-2 control-label">Newspaper Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="" name="newspaper_name" id = 'newspaper_name'>
                                    </div>
                                    <!-- page -->
                                    <label for="page" class="col-sm-2 control-label">Newspaper Page</label>   
                                    <div class="col-sm-4">
                                            <input type="number" class="form-control" value="" name="page" id = 'page'>
                                    </div>
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="adv_sellect" class="ping"> <h3>***RELEVANT INFORMATION HERE***</h3></div>Advertising/Pamphlets source description</legend>
                                <fieldset class="form-group">
                                    <label class="col-sm-2 control-label">IMPORTANT</label>
                                    <div class="col-sm-10">
                                        <h4>Details for Advertising/Pamphlets is given in uploaded pictures, address information and comments.<h4>
                                    </div>
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="other_sellect" class="ping"> <h3>***RELEVANT INFORMATION HERE***</h3></div>Other source description</legend>
                                <fieldset class="form-group">
                                    <label for = "specific_type" class = "col-sm-2 control-label">Type Specified</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="" name="specific_type" id ='specific_type'>
                                    </div>
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend>General address information</legend>
                                <fieldset class="form-group">
                                    <!-- Country -->
                                    <label for="country" class="col-sm-2 control-label">Country</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="" name="country">
                                    </div>
                                    <!-- Town -->
                                    <label for="town" class="col-sm-2 control-label">Town</label>   
                                    <div class="col-sm-4">
                                            <input type="text" class="form-control" value="" name="town">
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Area code -->
                                    <label for="area_district" class="col-sm-2 control-label">Area Code</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="" name="area_district">
                                    </div>
                                    <!-- Specific Address-->
                                    <label for="specific_address" class="col-sm-2 control-label">Specific Address</label>   
                                    <div class="col-sm-4">
                                            <input type="text" class="form-control" value="" name="specific_address">
                                    </div>
                                </fieldset>
                            </fieldset>   
                            <fieldset>
                                <legend>Upload Pictures</legend>                             
                                <fieldset class="form-group">
                                        <div class = "form-group">
                                            <label for = "image_check" class="col-sm-2 control-label">Would you like to upload pictures?</label>
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-default">
                                                        <input type="radio" name="img_upload" value="1">
                                                        Yes
                                                    </label>
                                                    <label class="btn btn-default">
                                                        <input type="radio" name="img_upload" value="0">
                                                        No
                                                    </label>
                                                </div>
                                                <div class = "col-sm-4 " id = 'img_upload'>
                                                    <input  type="file" class="form-control" name="images[]" multiple placeholder="images only" >
                                                </div>
                                        </div>
                                </fieldset> 
                            </fieldset>

                            <!---------------------->
                            <!-- Report Evaluation-->
                            <!---------------------->
                            <fieldset>
                                <legend>Report evaluation</legend>
                                <fieldset class="form-group">
                                    <!-- Evaluation -->
                                    <label for="fakenews_type" class="col-sm-2 control-label">Fakenews Type</label>
                                    <div class="col-sm-4">
                                    <select class = "form-control" name = "fakenews_type" id = "fakenews_type">
                                        @foreach($fakenews_type->sortBy('typename_en') as $type)
                                                <option value="{{ $type->typename }}" @if($type->typename=='Undefined') selected @endif>
                                                    {{ $type->typename_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="evaluation" class="col-sm-2 control-label">Evaluation (%Confidence)</label>
                                    <div class="col-sm-4">
                                        <input type="range" min="0" max="100" step="5" value="50" class="slider" id="evaluation" name ="evaluation">
                                        <span class = 'range-value'>50</span>
                                    </div>
                            </fieldset>
                            <!---------------------->
                            <!-- Operator actions -->
                            <!---------------------->
                            </fieldset>
                                <legend>Operator evaluation</legend>       
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
                                                <option value="{{ $priority->name }}"class="{{ $priority->name }}-priority">
                                                    {{ $priority->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Referenced by -->
                                <fieldset class="form-group">
                                    <label for="reference_by" class="col-sm-2 control-label">Reference by</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="reference_by">
                                            <option value="" disabled>Select an
                                                option...
                                            </option>
                                            @foreach($references_by as $reference_by)
                                                <option value="{{ $reference_by->name }}">
                                                {{ $reference_by->display_name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Informed -->
                                <fieldset class="form-group">
                                    <label for="reference_to" class="col-sm-2 control-label">Reference to</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="reference_to">
                                            <option value="" disabled>Select an
                                                option...
                                            </option>
                                            @foreach($references_to as $reference_to)
                                                <option value="{{ $reference_to->name }}">
                                                    {{ $reference_to->display_name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Actions -->
                                <fieldset class="form-group">
                                    <label for="actions" class="col-sm-2 control-label">Actions</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="actions"rows="3"></textarea>
                                    </div>
                                </fieldset>
                                <!-- Report Status -->
                                <fieldset class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="status">
                                            @foreach($status as $onestatus)
                                                @if ($onestatus->name != "New")
                                                    <option value="{{ $onestatus->name }}">
                                                        {{ $onestatus->name }}
                                                    </option>
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
                                        <input name="call_time" type='text' id="call_time" class="form-control form-inline" value="{{date('d/m/Y H:i')}}">
                                    </div>
                                </fieldset>

                                <fieldset class="form-group">
                                    <!-- Report Related Id -->
                                    <label for="RelatedId" class="col-sm-2 control-label">Related Fakenews
                                        ID </label>
                                    <div class="col-sm-4">
                                        <input type="number"  class="form-control" value=""  name="insident_reference_id">
                                        {{-- @if (isset($referenceidInfo['is_it_hotline']) && ($referenceidInfo['is_it_hotline']=="true"))
                                            @if(GroupPermission::usercan('view','hotline'))
                                                <a href="{{route('hotline.show',['id' => $helpline->insident_reference_id ])}}">Link
                                                    to HotLine</a>
                                            @else
                                                Not Permission to View Hotline
                                            @endif
                                        @else
                                            @if(GroupPermission::usercan('view','helpline'))
                                                <a href="{{route('show-helpline',['id' => $helpline->insident_reference_id ])}}">Link
                                                    to Helpline</a>
                                            @else
                                                Not Permission to View HelpLine
                                            @endif
                                        @endif --}}
                                    </div>
                                </fieldset>
                            </fieldset>

                            <div class="help-block"><b>* Required fields.</b></div>

                            {{-- When new HELPLINE report is created and submitted by operator --}}
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
        $(document).ready(function () {
            $('#img_upload').hide();
            $('.ping').hide();
            
            $('#source_url').prop('disabled',true)
            $('#title').prop('disabled',true)
            $('#source_document').prop('disabled',true)
            $('#tv_channel').prop('disabled',true)
            $('#tv_prog_title').prop('disabled',true)
            $('#radio_station').prop('disabled',true)
            $('#radio_freq').prop('disabled',true)
            $('#newspaper_name').prop('disabled',true)
            $('#page').prop('disabled',true)
            $('#specific_type').prop('disabled',true)

            $('#fakenews_source_type').change(function() {
            if(this.value == "Internet") {
                $('#source_url').prop('disabled',false)
                $('#title').prop('disabled',false)
                $('#source_document').prop('disabled',false)
                $('#tv_channel').prop('disabled',true)
                $('#tv_prog_title').prop('disabled',true)
                $('#radio_station').prop('disabled',true)
                $('#radio_freq').prop('disabled',true)
                $('#newspaper_name').prop('disabled',true)
                $('#page').prop('disabled',true)
                $('#specific_type').prop('disabled',true)
                //messeges
                $('#int_sellect').show();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            } else if(this.value == "TV") {
                $('#source_url').prop('disabled',true)
                $('#title').prop('disabled',true)
                $('#source_document').prop('disabled',true)
                $('#tv_channel').prop('disabled',false)
                $('#tv_prog_title').prop('disabled',false)
                $('#radio_station').prop('disabled',true)
                $('#radio_freq').prop('disabled',true)
                $('#newspaper_name').prop('disabled',true)
                $('#page').prop('disabled',true)
                $('#specific_type').prop('disabled',true)
                //messeges
                $('#int_sellect').hide();
                $('#tv_sellect').show();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            } else if(this.value == "Radio") {
                $('#source_url').prop('disabled',true)
                $('#title').prop('disabled',true)
                $('#source_document').prop('disabled',true)
                $('#tv_channel').prop('disabled',true)
                $('#tv_prog_title').prop('disabled',true)
                $('#radio_station').prop('disabled',false)
                $('#radio_freq').prop('disabled',false)
                $('#newspaper_name').prop('disabled',true)
                $('#page').prop('disabled',true)
                $('#specific_type').prop('disabled',true)
                //messeges
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').show();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            }else if(this.value == "Newspaper"){
                $('#source_url').prop('disabled',true)
                $('#title').prop('disabled',true)
                $('#source_document').prop('disabled',true)
                $('#tv_channel').prop('disabled',true)
                $('#tv_prog_title').prop('disabled',true)
                $('#radio_station').prop('disabled',true)
                $('#radio_freq').prop('disabled',true)
                $('#newspaper_name').prop('disabled',false)
                $('#page').prop('disabled',false)
                $('#specific_type').prop('disabled',true)
                //messeges
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').show();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            }else if(this.value == "Advertising/Pamphlets") {
                $('#source_url').prop('disabled',true)
                $('#title').prop('disabled',true)
                $('#source_document').prop('disabled',true)
                $('#tv_channel').prop('disabled',true)
                $('#tv_prog_title').prop('disabled',true)
                $('#radio_station').prop('disabled',true)
                $('#radio_freq').prop('disabled',true)
                $('#newspaper_name').prop('disabled',true)
                $('#page').prop('disabled',true)
                $('#specific_type').prop('disabled',true)
                //messeges
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').show();
                $('#other_sellect').hide();
            }else if(this.value == "Other") {
                $('#source_url').prop('disabled',true)
                $('#title').prop('disabled',true)
                $('#source_document').prop('disabled',true)
                $('#tv_channel').prop('disabled',true)
                $('#tv_prog_title').prop('disabled',true)
                $('#radio_station').prop('disabled',true)
                $('#radio_freq').prop('disabled',true)
                $('#newspaper_name').prop('disabled',true)
                $('#page').prop('disabled',true)
                $('#specific_type').prop('disabled',false)
                //messeges
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').show();
            }}).change();

            $('input[name="img_upload"]').change(function() {
                if((this.value === "1") && this.checked) {
                    $('#img_upload').show();
                } else if((this.value === "0") && this.checked) {
                    $('#img_upload').hide();
                }
            }).change();
            
            $('#fakenews_type').change(function() {
                if(this.value === "Undefined") {
                    $('#evaluation').prop('disabled',true)
                } else {
                    $('#evaluation').prop('disabled',false)
                }
            }).change();

            $('.slider').on('input', function() {
                $(this).next('.range-value').html(this.value);
            });

            $('.js-example-basic-multiple').select2();
            $('#call_time').datetimepicker({
                locale: 'en-gb'
            });

        });
    </script>
@endsection
