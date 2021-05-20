@extends('layouts.app')

@section('content')
    <div class="container report-details" id="fakenews-report-edit">
        <div class="row">
            <div class="col-md-12">

                <form method="PUT" action="{{route('edit-fakenews',['id' => $fakenews->id ])}}" id="submit-form"
                      class="form-horizontal">

                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h4 class="pull-left">FAKENEWS - Report ID : # {{ $fakenews->id }}</h4>
                            <div class="pull-right form-actions">
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
                                        @if($fakenews->name == null)
                                            <input type="text" class="form-control" value="" placeholder="Not provided"
                                                   disabled>
                                        @else
                                            <input type="text" class="form-control" value="{{ $fakenews->name }}"
                                                   disabled>
                                        @endif
                                    </div>
                                    <!-- Report Surname -->
                                    <label for="surname" class="col-sm-2 control-label">Surname</label>
                                    <div class="col-sm-4">
                                        @if($fakenews->surname == null)
                                            <input type="text" class="form-control" value="" placeholder="Not provided"
                                                   disabled>
                                        @else
                                            <input type="text" class="form-control" value="{{ $fakenews->surname }}"
                                                   disabled>
                                        @endif
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Email -->
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        @if($fakenews->email == null)
                                            <input type="text" class="form-control" value="" placeholder="Not provided"
                                                   disabled>
                                        @else
                                            <input type="text" class="form-control" value="{{ $fakenews->email }}"
                                                   disabled>
                                        @endif
                                    </div>
                                    <!-- Report Phone -->
                                    <label for="phone" class="col-sm-2 control-label">Phone</label>
                                    <div class="col-sm-4">
                                        @if($fakenews->phone == null)
                                            <input type="text" class="form-control" value="" placeholder="Not provided"
                                                   disabled>
                                        @else
                                            <input type="text" class="form-control" value="{{ $fakenews->phone }}"
                                                   disabled>
                                        @endif
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Gender -->
                                    <label for="gender" class="col-sm-2 control-label">Gender</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="gender">
                                            <option value="0" @if($fakenews->age == "0") selected @endif disabled>Select
                                                an option...
                                            </option>
                                            <option value="" @if($fakenews->gender == null) selected @endif>Not
                                                Provided
                                            </option>
                                            <option value="male" @if($fakenews->gender == 'male') selected @endif>Male
                                            </option>
                                            <option value="female" @if($fakenews->gender == 'female') selected @endif>
                                                Female
                                            </option>
                                        </select>
                                    </div>
                                    <!-- Report Age -->
                                    <label for="age" class="col-sm-2 control-label">Age</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="age" name="age">
                                            <option value="0" @if($fakenews->age == "0") selected @endif disabled>Select
                                                an option...
                                            </option>
                                            <option value="" @if($fakenews->age == null) selected @endif>Not Provided
                                            </option>
                                            <option value="5-11" @if($fakenews->age == '5-11') selected @endif>5-11
                                                years
                                            </option>
                                            <option value="12-18" @if($fakenews->age == '12-18') selected @endif>12-18
                                                years
                                            </option>
                                            <option value="18+" @if($fakenews->age == '18+') selected @endif>18+
                                            </option>
                                        </select>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report User Role -->
                                    <label for="report_role" class="col-sm-2 control-label">User role</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="report_role">
                                            <option value="0" @if($fakenews->user_role == "0") selected @endif disabled>
                                                Select an option...
                                            </option>
                                            <option value="" @if($fakenews->user_role == null) selected @endif>Not
                                                Provided
                                            </option>
                                            @foreach($report_roles as $report_role)
                                                <option value="{{ $report_role->name }}"
                                                        @if($fakenews->report_role == $report_role->name ) selected @endif> {{ $report_role->display_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Report Contact Method -->
                                    <label for="submission_type" class="col-sm-2 control-label">Contact method</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="submission_type" >
                                            <option value="0" @if($fakenews->submission_type == "0") selected
                                                    @endif disabled>Select an option...
                                            </option>
                                            @foreach($submission_types as $submission_type)
                                                <option value="{{ $submission_type->name }}"
                                                        @if($fakenews->submission_type == $submission_type->name ) selected @endif> {{ $submission_type->display_name_en }}</option>
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
                                            @foreach($fakenews_source_type->sortBy('typename_en') as $source_type)
                                                <option value="{{ $source_type->typename }}"
                                                        @if( $fakenews->fakenews_source_type == $source_type->typename ) selected @endif>{{ $source_type->typename_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- publication date -->
                                    <label for="publication_date" class="col-sm-2 control-label" required>Publication Date</label>
                                    <div class="col-sm-4">
                                            <input type="date" class="form-control" value="{{ $fakenews->publication_date }}" 
                                            name="publication_date">
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
                                        <input type="time" class="form-control" value="{{ $fakenews->publication_time }}" 
                                        name="publication_time">
                                    </div>
                                </fieldset>
                                <!-- Report User Comments -->
                                <fieldset class="form-group">
                                    <label for="comments" class="col-sm-2 control-label">User comments</label>
                                    <div class="col-sm-10">
                                        @if($fakenews->comments == null)
                                            <?php $comments = "Not provided."; ?>
                                        @else
                                            <?php $comments = Crypt::decrypt($fakenews->comments); ?>
                                        @endif
                                    <textarea class="form-control" name="comments" rows="3">{{ $comments  }}</textarea>
                                    </div>
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="int_sellect" class="ping"> <h3>***RELEVANT INFORMATION HERE***</h3></div>Internet source description </legend>
                                    <fieldset class="form-group">
                                        <!-- Website url -->
                                        <label for="source_url" class="col-sm-2 control-label">Website URL</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{ $fakenews->source_url }}"
                                                    name="source_url">
                                        </div>
                                        <!-- News Title -->
                                        <label for="title" class="col-sm-2 control-label">News Title</label>   
                                        <div class="col-sm-4">
                                                <input type="text" class="form-control" value="{{ $fakenews->title }}" 
                                                name="title">
                                        </div>
                                    </fieldset>
                                    <!--Full/Part of Source article/news-->
                                    <fieldset class="form-group">
                                        <label for="source_document" class="col-sm-2 control-label">Source Document</label>
                                        <div class="col-sm-10">
                                            @if($fakenews->source_document == null)
                                                <?php $source_document = null; ?>
                                            @else
                                                <?php $source_document = Crypt::decrypt($fakenews->source_document); ?>
                                            @endif
                                        <textarea class="form-control" name="source_document" rows="5">{{ $source_document  }}</textarea>
                                        </div>
                                    </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="tv_sellect" class="ping"> <h3>***RELEVANT INFORMATION HERE***</h3></div>TV source description</legend>
                                    <fieldset class="form-group">
                                        <!-- Channel title -->
                                        <label for="tv_channel" class="col-sm-2 control-label">Channel Title</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{ $fakenews->tv_channel }}"
                                                    name="tv_channel">
                                        </div>
                                        <!-- Programme title -->
                                        <label for="tv_prog_title" class="col-sm-2 control-label">Programme Title</label>   
                                        <div class="col-sm-4">
                                                <input type="text" class="form-control" value="{{ $fakenews->tv_prog_title }}" 
                                                name="tv_prog_title">
                                        </div>
                                    </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="radio_sellect" class="ping"> <h3>***RELEVANT INFORMATION HERE***</h3></div>Radio source description</legend>
                                <fieldset class="form-group">
                                    <!-- Radio_station -->
                                    <label for="radio_station" class="col-sm-2 control-label">Radio Station Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="{{ $fakenews->radio_station }}"
                                                name="radio_station">
                                    </div>
                                    <!-- Radio station frequency -->
                                    <label for="radio_freq" class="col-sm-2 control-label">Radio Station Frequency [MHz]</label>   
                                    <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{ $fakenews->radio_freq }}" 
                                            name="radio_freq">
                                    </div>
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend><div id="newspaper_sellect" class="ping">  <h3>***RELEVANT INFORMATION HERE***</h3></div>Newspaper source description</legend>
                                <fieldset class="form-group">
                                    <!-- Newspaper name -->
                                    <label for="newspaper_name" class="col-sm-2 control-label">Newspaper Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="{{ $fakenews->newspaper_name }}"
                                                name="newspaper_name">
                                    </div>
                                    <!-- page -->
                                    <label for="page" class="col-sm-2 control-label">Newspaper Page</label>   
                                    <div class="col-sm-4">
                                            <input type="number" class="form-control" value="{{ $fakenews->page }}" 
                                            name="page">
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
                                        <input type="text" class="form-control" value="{{ $fakenews->specific_type }}" 
                                            name="specific_type">
                                    </div>
                                </fieldset>
                            </fieldset>
                            <fieldset>
                                <legend>General address information</legend>
                                <fieldset class="form-group">
                                    <!-- Country -->
                                    <label for="country" class="col-sm-2 control-label">Country</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="{{ $fakenews->country }}"
                                                name="country">
                                    </div>
                                    <!-- Town -->
                                    <label for="town" class="col-sm-2 control-label">Town</label>   
                                    <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{ $fakenews->town }}" 
                                            name="town">
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Area code -->
                                    <label for="area_district" class="col-sm-2 control-label">Area Code</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="{{ $fakenews->area_district }}"
                                                name="area_district">
                                    </div>
                                    <!-- Specific Address-->
                                    <label for="specific_address" class="col-sm-2 control-label">Specific Address</label>   
                                    <div class="col-sm-4">
                                            <input type="text" class="form-control" value="{{ $fakenews->specific_address }}" 
                                            name="specific_address">
                                    </div>
                                </fieldset>
                            </fieldset>   
                            <fieldset>
                                <legend>Uploaded pictures </legend>
                                @if(count($pictures)>0)
                                    <fieldset class = "form-group">
                                        <label for = "image_check" class = "col-sm-2 control-label">Images have been uploaded. would you like to see them?</label>
                                        <input type = "hidden" name = "img_upload" value = 1></input>
                                        <div class="btn-group col-sm-8" data-toggle="buttons">
                                            <label class="btn btn-default">
                                                <input type="radio" name="img_show" value="1" >Show</input>
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="img_show" value="0" pressed >Hide</input>
                                            </label>
                                        </div>
                                    </fieldset>
                                    <fieldset class = "form-group" id = 'img_show'>
                                        @foreach($pictures as $img_path)
                                            <fieldset class="form-group">
                                                <div class = "col-sm-4 control-label" >
                                                    <label for = "evidence_img" class = "col-sm-4 control-label">Title: {{$img_path}}</label>
                                                    <a  
                                                    class="btn btn-danger" data-toggle="modal" data-target="#myModal-delete">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                    Remove</a>
                                                </div>
                                                <div class="col-sm-7">
                                                    <img class ="img-thumbnail"  src="{{ asset('storage/uploaded_images/' . $img_path) }}" alt="image is not showable."
                                                    title="{{$img_path}}" id='evidence_img'>
                                                </div>
                                            </fieldset>

                                            <!-- Modal -->
                                            <div id="myModal-delete" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this image? It will be deleted forever.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                            <a class="btn btn-danger" 
                                                            href = "{{route('delete-image-fakenews',['fakenews'=>$fakenews->id ,'image_id' => array_search($img_path, $pictures)])}}">
                                                            Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </fieldset>
                                        @endforeach
                                    
                                    <fieldset class = "form-group">
                                        <label for = "image_check" class="col-sm-2 control-label">Would you like to upload pictures?</label>
                                        <div class = "col-sm-4 " id = 'img_upload'>
                                            <input  type="file" class="form-control" name="images[]" multiple placeholder="images only" >
                                        </div>
                                        <div class="btn-group col-sm-2" data-toggle="buttons">
                                            <label class="btn btn-default">
                                                <input type="radio" name="img_upload" value="1">
                                                Yes
                                            </label>
                                            <label class="btn btn-default">
                                                <input type="radio" name="img_upload" value="0">
                                                No
                                            </label>
                                        </div>

                                    </fieldset>
                                @else
                                    <fieldset class="form-group">
                                        <label for = "evidence_img" class = "col-sm-10 control-label" ></label>
                                        <div class="col-sm-10">
                                            <h3>No images were uploaded.</h3>
                                            <input type = "hidden" name = "img_upload" value = 0></input>
                                        </div>
                                    </fieldset>
                                @endif
                            </fieldset>       
                            
                            <!---------------------->
                            <!-- Operator actions -->
                            <!---------------------->
                            <!-- need to add evaluation and fake news type here -->
                            <fieldset>
                                <legend>Operator actions</legend>
                                <fieldset class="form-group">
                                    <!-- Evaluation -->
                                    <label for="evaluation" class="col-sm-2 control-label">Operator Fakenews Evaluation</label>
                                    <div class="col-sm-4">
                                        <input type="range" min="0" max="100" step="5" value="{{ $fakenews->evaluation }}" class="slider" id="evaluation" name ="evaluation">
                                        <span class = 'range-value'>{{ $fakenews->evaluation }}</span>
                                    </div>
                
                                    <label for="fakenews_type" class="col-sm-2 control-label">Fakenews Type</label>
                                    <div class="col-sm-4">
                                    <select class = "form-control" name = "fakenews_type" id = "fakenews_type">
                                            @foreach($fakenews_type->sortBy('typename_en') as $type)
                                                <option value="{{ $type->typename }}"
                                                        @if( $fakenews->fakenews_type == $type->typename ) selected @endif>{{ $type->typename_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group">
                                    <!-- Report Opened by operator -->
                                    <label for="user_opened" class="col-sm-2 control-label">Opened by operator</label>
                                    <div class="col-sm-4">
                                        @if($fakenews->firstResponder == null)
                                            <input type="text" class="form-control" value = null  placeholder="No one" disabled>
                                        @else
                                            <input type = "text" class = "form-control"  value = "{{$fakenews->firstResponder->name}}" 
                                            disabled>
                                            <input type = "hidden" name = "user_opened" value = "{{$fakenews->firstResponder->id}}">
                                        @endif
                                    </div>
                                    <!-- Report Forward to operator -->
                                    <label for="user_assigned" class="col-sm-2 control-label">Forward to
                                        operator</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="user_assigned">
                                            @if($fakenews->user_assigned == null)
                                                <option value selected>No one</option>
                                            @endif
                                            @foreach($users as $user)
                                                @if($user->hasRole('operator'))
                                                    <option value="{{ $user->id }}"
                                                            @if ($fakenews->user_assigned == $user->id) selected @endif>{{ $user->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Priority -->
                                <fieldset class="form-group">
                                    <label for="priority" class="col-sm-2 control-label">Priority</label>
                                    <div class="col-sm-4">
                                        <select class="form-control {{ $fakenews->priority }}-priority" name="priority">
                                            @foreach($priorities as $priority)
                                                <option value="{{ $priority->name }}"
                                                        class="{{ $priority->name }}-priority"
                                                        @if ($fakenews->priority == $priority->name) selected @endif>{{ $priority->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Referenced by -->
                                <fieldset class="form-group">
                                    <label for="reference_by" class="col-sm-2 control-label">Reference by</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="reference_by">
                                            <option value="" disabled
                                                    @if($fakenews->reference_by == null) selected @endif >Select an
                                                option...
                                            </option>
                                            @foreach($references_by as $reference_by)
                                                <option value="{{ $reference_by->name }}"
                                                        @if($fakenews->reference_by == $reference_by->name) selected @endif>{{ $reference_by->display_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Informed -->
                                <fieldset class="form-group">
                                    <label for="reference_to" class="col-sm-2 control-label">Reference to</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="reference_to">
                                            <option value="" disabled
                                                    @if($fakenews->reference_to == null) selected @endif>Select an
                                                option...
                                            </option>
                                            @foreach($references_to as $reference_to)
                                                <option value="{{ $reference_to->name }}"
                                                        @if($fakenews->reference_to == $reference_to->name) selected @endif>{{ $reference_to->display_name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- Report Actions -->
                                <fieldset class="form-group">
                                    <label for="actions" class="col-sm-2 control-label">Actions</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="actions"
                                                  rows="3"> {{ $fakenews->actions}}</textarea>
                                    </div>
                                </fieldset>
                                <!-- Report Status -->
                                <fieldset class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="status">
                                            @foreach($status as $onestatus)
                                                @if ($onestatus->name != "New")
                                                    <option value="{{ $onestatus->name }}"
                                                            @if ($fakenews->status == $onestatus->name) selected @endif >{{$onestatus->name }}</option>
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
                                               class="form-control form-inline" value="{{ $fakenews->call_time }}"/>
                                    </div>
                                </fieldset>

                                <fieldset class="form-group">
                                    <!-- Report Related Id -->
                                    <label for="RelatedId" class="col-sm-2 control-label">Related Fakenews
                                        ID </label>
                                    <div class="col-sm-4">
                                        @if($fakenews->insident_reference_id == null)
                                            <input type="number"  class="form-control" value=""
                                                   name="insident_reference_id">
                                        @else
                                            <input type="number" class="form-control"
                                                   value="{{ $fakenews->insident_reference_id }}"
                                                   name="insident_reference_id">
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
            $('#img_upload').hide();
            $('#img_show').hide();
            $('.ping').hide();

/*             $('input[name = "fakenews_source_type"]').change(function(){
                var selection = $('#business-fakenews_source_type').val();
                
                switch(selection){
                    case "Internet":
                        $('#int_sellect').show();
                        break;
                }
            }); */
        
/*             if($("#fakenews_source_type").val() == "Internet") {
                $('#int_sellect').show();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            } else if($("#fakenews_source_type").val()== "TV") {
                $('#int_sellect').hide();
                $('#tv_sellect').show();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            } else if($("#fakenews_source_type").val() == "Radio") {
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').show();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            }else if($("#fakenews_source_type").val() == "Newspaper")  {
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').show();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            }else if($("#fakenews_source_type").val() == "Advertising/Pamphlets") {
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').show();
                $('#other_sellect').hide();
            }else if($("#fakenews_source_type").val() == "Other") {
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').show();
            } */

            //alert($("#fakenews_source_type").val());
            $('#fakenews_source_type').change(function() {
            if(this.value == "Internet") {
                $('#int_sellect').show();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            } else if(this.value == "TV") {
                $('#int_sellect').hide();
                $('#tv_sellect').show();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            } else if(this.value == "Radio") {
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').show();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            }else if(this.value == "Newspaper")  {
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').show();
                $('#adv_sellect').hide();
                $('#other_sellect').hide();
            }else if(this.value == "Advertising/Pamphlets") {
                $('#int_sellect').hide();
                $('#tv_sellect').hide();
                $('#radio_sellect').hide();
                $('#newspaper_sellect').hide();
                $('#adv_sellect').show();
                $('#other_sellect').hide();
            }else if(this.value == "Other") {
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

            $('input[name="img_show"]').change(function() {
                if((this.value === "1") && this.checked) {
                    $('#img_show').show();
                } else if((this.value === "0") && this.checked) {
                    $('#img_show').hide();
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