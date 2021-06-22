@extends('layouts.app')

@section('content')

    <div class="container">
        <!-------------->
        <!-- FILTERS  -->
        <!-------------->
        @if(GroupPermission::usercan('view','helpline') || GroupPermission::usercan('view','hotline') || GroupPermission::usercan('view','fakenews')  )
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{ route('home') }} " class="form-inline results-filters">

                        <i class="fa fa-filter" aria-hidden="true"> Filters: </i>

                        <div class="form-group">
                            <label for="filterStatus">Status</label>
                            <select name="filterStatus" class="form-control">
                                <option value="*" @if (empty(old('filterStatus')) || (old('filterStatus')=='*')))
                                        selected @endif>New & Opened
                                </option>
                                @if (auth()->user()->hasRole("operator"))
                                    @foreach($status as $astatus)
                                        @if ($astatus->name != "Closed")
                                            <option value="{{ $astatus->name }}"
                                                    @if (old('filterStatus') == $astatus->name) selected @endif > {{ $astatus->name }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($status as $astatus)
                                        <option value="{{ $astatus->name }}"
                                                @if (old('filterStatus') == $astatus->name) selected @endif > {{ $astatus->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- will add a filter for incident type to show-->
                        {{-- 
                        <div class="form-group">
                            <label for="filterStatus">Incident Type</label>
                            <select name="filterStatus" class="form-control">
                                <option value="*" @if (empty(old('filterStatus')) || (old('filterStatus')=='*')))
                                        selected @endif>All
                                </option>
                                @if (auth()->user()->hasRole("operator"))
                                    @foreach($status as $astatus)
                                        @if ($astatus->name != "Closed")
                                            <option value="{{ $astatus->name }}"
                                                    @if (old('filterStatus') == $astatus->name) selected @endif > {{ $astatus->name }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($status as $astatus)
                                        <option value="{{ $astatus->name }}"
                                                @if (old('filterStatus') == $astatus->name) selected @endif > {{ $astatus->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        --}}

                        {{--  <div class="form-group">
                            <label for="sortUser">User</label>
                            <select name="sortUser" class="form-control">
                                <option value="default">--</option>
                                <option value="*">ALL</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if (old('sortUser') == $astatus->name) selected  @endif> {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>  --}}

                        {{ csrf_field() }}

                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div> <!-- END .panel -->
        @endif


        @include('partials.errors')

        <div class="row">
            <div class="col-md-12">

                <!---------------------->
                <!-- HELPLINE REPORTS -->
                <!---------------------->
                @if(GroupPermission::usercan('view','helpline'))
                    <div class="panel panel-default">

                        <div class="panel-heading clearfix">
                            <h4 class="pull-left"><i class="fa fa-file-text-o"></i> Helpline Reports
                                ({{ $helpline->where('is_it_hotline','=','false')->count() }})</h4>
                            <div class="pull-right form-actions">
                                @if(GroupPermission::usercan('create','helpline'))
                                    <a href="{{ route('create-helpline') }}" class="btn btn-primary"><i
                                                class="fa fa-plus" aria-hidden="true"></i> New</a>
                                @endif
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover" id="" style="">
                                    <thead>
                                    <tr>
                                        <th valign="middle">#</th>
                                        <th>ID</th>
                                        <th>Operator(s)</th>
                                        {{-- <th>Submission Type</th> --}}
                                        <th>Resource Type</th>
                                        <th>Content Type</th>
                                        <th>User Comments</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($helpline)
                                        <?php $counter = 1; ?>
                                        @foreach ($helpline as $indexKey => $report)
                                            @if(isset($report->is_it_hotline) && $report->is_it_hotline != "true")
                                                <tr class="{{ $report->priority }}-priority">
                                                    <td class="col1">
                                                        {{ $counter++ }}
                                                    </td>
                                                    <td>
                                                        {{$report->id}}
                                                    </td>
                                                    <td>
                                                        @if(isset($report->firstResponder))
                                                            <?php
                                                            $words = explode(" ", $report->firstResponder->name);
                                                            $firstname = $words[0];
                                                            ?>
                                                            <span class="top"
                                                                  title="{{$report->firstResponder->name}}">{{$firstname}}</span>
                                                        @endif
                                                        @if(isset($report->lastResponder))
                                                            <?php
                                                            $words = explode(" ", $report->lastResponder->name);
                                                            $firstname = $words[0];
                                                            ?>
                                                            <span class="top" title="{{$report->lastResponder->name}}"> -> {{$firstname}}</span>
                                                        @endif
														@if($report->forwarded=="true")
															(Forwarded From Hotline)
														@endif
                                                    </td>
                                                    {{--
                                                    <td>
                                                        @foreach ($submission_types as $submission_type)
                                                            @if($report->submission_type == $submission_type->name) {{$submission_type->display_name_en}} @endif
                                                        @endforeach
                                                    </td>
                                                    --}}
                                                    <td>
                                                        @foreach ($resource_types as $resource_type)
                                                            @if($report->resource_type == $resource_type->name) {{$resource_type->display_name_en}} @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($content_types as $content_type)
                                                            @if($report->content_type == $content_type->name) {{$content_type->display_name_en}} @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $usercomments = strip_tags(Crypt::decrypt($report->comments));

                                                            if (strlen($usercomments) > 20) {
                                                                $stringCut = substr($usercomments, 0, 20);
                                                                $usercomments = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
                                                            }
                                                            echo $usercomments;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        {{ $report->status}}
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $report->updated_at)->diffForHumans()}}
                                                    </td>
                                                    <td class="">
                                                        @if(GroupPermission::usercan('view','helpline'))
                                                        @role('manager')
                                                            <a href="{{ route('show-helpline-manager',['id' => $report->id]) }}"
                                                               class="btn btn-sm btn-default">
                                                                <i class="fa fa-eye" aria-hidden="true"></i> View
                                                            </a>
                                                        @endrole
                                                        @endif
                                                        @if(GroupPermission::usercan('edit','helpline'))
                                                            <a href="{{ route('show-helpline',['id' => $report->id]) }}"
                                                               class="btn btn-sm btn-default">
                                                                <i class="fa fa-eye" aria-hidden="true"></i> Investigate
                                                            </a>
                                                        @endif
                                                        {{--@if($report->status=="Closed")--}}
                                                        @if(GroupPermission::usercan('delete','helpline'))
                                                            <button class="btn btn-danger" id="delete-this"
                                                                    data-target="helpline" data-id="{{ $report->id }}"
                                                                    data-place="home" data-content="{{Auth::user()->id}}"><span
                                                                        class="glyphicon glyphicon-trash"></span>Delete
                                                            </button>
                                                            {{-- <button class="btn btn-danger" id="delete-this" data-target="helpline" data-id="{{ $report->id }}" data-place="home"> <span class="glyphicon glyphicon-trash"></span>Delete</button> --}}
                                                        @endif
                                                        {{-- @endif --}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <p> Nothing yet</p>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                @endif

                <!---------------------->
                <!-- HOTLINE REPORTS  -->
                <!---------------------->
                @if(GroupPermission::usercan('view','hotline'))
                    <div class="panel panel-default">

                        <div class="panel-heading clearfix">
                            <h4 class="pull-left"><i class="fa fa-file-text-o"></i> Hotline Reports
                                ({{ $helpline->where('is_it_hotline','=','true')->count() }})</h4>
                            <div class="pull-right form-actions">
                                @if(GroupPermission::usercan('create','hotline'))
                                    <a href="{{ route('hotline.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus" aria-hidden="true"></i> New</a>
                                @endif
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover" id="" style="">
                                    <thead>
                                    <tr>
                                        <th valign="middle">#</th>
                                        <th>ID</th>
                                        <th>Operator(s)</th>
                                        {{-- <th>Submission Type</th> --}}
                                        <th>Resource Type</th>
                                        <th>Content Type</th>
                                        <th>User Comments</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($helpline)
                                        <?php $counter = 1; ?>
                                        @foreach ($helpline as $indexKey => $report)
                                            @if(isset($report->is_it_hotline) && $report->is_it_hotline == "true")
                                                <tr class="{{ $report->priority }}-priority">
                                                    <td class="col1">
                                                        {{ $counter++ }}
                                                    </td>
                                                    <td>
                                                        {{$report->id}}
                                                    </td>
                                                    <td>
                                                        @if(isset($report->firstResponder))
                                                            <?php
                                                            $words = explode(" ", $report->firstResponder->name);
                                                            $firstname = $words[0];
                                                            ?>
                                                            <span class="top"
                                                                  title="{{$report->firstResponder->name}}">{{$firstname}}</span>
                                                        @endif
                                                        @if(isset($report->lastResponder))
                                                            <?php
                                                            $words = explode(" ", $report->lastResponder->name);
                                                            $firstname = $words[0];
                                                            ?>
                                                            <span class="top" title="{{$report->lastResponder->name}}"> -> {{$firstname}}</span>
                                                        @endif
														@if($report->forwarded=="true")
															(Forwarded from Helpline)
														@endif														
                                                    </td>
                                                    {{--
                                                    <td>
                                                        @foreach ($submission_types as $submission_type)
                                                            @if($report->submission_type == $submission_type->name) {{$submission_type->display_name_en}} @endif
                                                        @endforeach
                                                    </td>
                                                    --}}
                                                    <td>
                                                        @foreach ($resource_types as $resource_type)
                                                            @if($report->resource_type == $resource_type->name) {{$resource_type->display_name_en}} @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($content_types as $content_type)
                                                            @if($report->content_type == $content_type->name) {{$content_type->display_name_en}} @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $usercomments = strip_tags(Crypt::decrypt($report->comments));

                                                        if (strlen($usercomments) > 20) {
                                                            $stringCut = substr($usercomments, 0, 20);
                                                            $usercomments = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
                                                        }
                                                        echo $usercomments;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        {{ $report->status}}
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $report->updated_at)->diffForHumans()}}
                                                    </td>
                                                    <td class="">
                                                        {{-- @if(GroupPermission::usercan('view','hotline')) --}}
                                                        {{-- @endif --}}
                                                        @if(GroupPermission::usercan('view','hotline'))
                                                        @role('manager')
                                                            <a href="{{ route('hotline.show.manage',['id' => $report->id]) }}"
                                                               class="btn btn-sm btn-default">
                                                                <i class="fa fa-eye" aria-hidden="true"></i> View
                                                            </a>
                                                        @endrole
                                                        @endif
                                                        @if(GroupPermission::usercan('edit','hotline'))
                                                            <a href="{{ route('hotline.show',['id' => $report->id]) }}"
                                                               class="btn btn-sm btn-default">
                                                                <i class="fa fa-eye" aria-hidden="true"></i> Investigate
                                                            </a>
                                                        @endif
                                                        {{-- @if($report->status=="Closed") --}}
                                                        @if(GroupPermission::usercan('delete','hotline'))
                                                            <button class="btn btn-danger" id="delete-this"
                                                                    data-target="hotline" data-id="{{ $report->id }}"
                                                                    data-place="home" data-content="{{Auth::user()->id}}">
                                                                <span class="glyphicon glyphicon-trash"></span>Delete
                                                            </button>
                                                        @endif
                                                        {{-- @endif --}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <p> Nothing yet</p>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            @endif <!-- end if GroupPermission::usercan('view','hotline') -->

            </div>
        </div>

                                                       
                <!---------------------->
                <!-- FAKENEWS REPORTS -->
                <!---------------------->
                @if(GroupPermission::usercan('view','fakenews'))
                    <div class="panel panel-default">

                        <div class="panel-heading clearfix">
                            <h4 class="pull-left"><i class="fa fa-file-text-o"></i> Fakenews Reports
                            ({{ $fakenews->count() }})</h4>
                            <div class="pull-right form-actions">
                                @if(GroupPermission::usercan('create','fakenews'))
                                    <a href="{{ route('create.fakenews') }}" class="btn btn-primary"><i
                                                class="fa fa-plus" aria-hidden="true"></i> New</a>
                                @endif
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover" id="" style="">
                                    <thead>
                                    <tr>
                                        <th valign="middle">#</th>
                                        <th>ID</th>
                                        <th>Operator(s)</th>
                                        {{-- <th>Submission Type</th> --}}
                                        <th>Fakenews Source Type</th>
                                        <th>Fakenews Type</th>
                                        <th>User Comments</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($fakenews)
                                        <?php $counter = 1; ?>
                                        @foreach ($fakenews as $indexKey => $report)
                                            <tr class="{{ $report->priority }}-priority">
                                                <td class="col1">
                                                    {{ $counter++ }}
                                                </td>
                                                <td>
                                                    {{$report->id}}
                                                </td>
                                                <td>
                                                    @if(isset($report->firstResponder))
                                                        <?php
                                                        $words = explode(" ", $report->firstResponder->name);
                                                        $firstname = $words[0];
                                                        ?>
                                                        <span class="top"
                                                                title="{{$report->firstResponder->name}}">{{$firstname}}</span>
                                                    @endif
                                                    @if(isset($report->lastResponder))
                                                        <?php
                                                        $words = explode(" ", $report->lastResponder->name);
                                                        $firstname = $words[0];
                                                        ?>
                                                        <span class="top" title="{{$report->lastResponder->name}}"> -> {{$firstname}}</span>
                                                    @endif													
                                                </td>
                                                {{--
                                                <td>
                                                    @foreach ($submission_types as $submission_type)
                                                         @if($report->submission_type == $submission_type->name) {{$submission_type->display_name_en}} @endif
                                                    @endforeach
                                                </td>
                                                --}}
                                                <td>
                                                    @foreach ($fakenews_source_type as $source_type)
                                                          @if($report->fakenews_source_type == $source_type->typename){{$source_type->typename_en}} @endif
                                                    @endforeach
                                                </td>
                                                <td> 
                                                    @foreach ($fakenews_type as $type)
                                                        @php
                                                        if ($report->fakenews_type == "Undefined"){
                                                            echo "<strong>";
                                                        };
                                                        @endphp
                                                        @if($report->fakenews_type == $type->typename) {{$type->typename_en}} @if($type->typename_en !="Undefined") {{ '('. $report->evaluation . '%' . ')' }} @endif @endif
                                                        
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <?php
                                                    $usercomments = strip_tags(Crypt::decrypt($report->comments));

                                                    if (strlen($usercomments) > 20) {
                                                        $stringCut = substr($usercomments, 0, 20);
                                                        $usercomments = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
                                                    }
                                                    echo $usercomments;
                                                    ?>
                                                </td>
                                                <td>
                                                    {{ $report->status}}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $report->updated_at)->diffForHumans()}}
                                                </td>
                                                <td class="">
                                                    {{-- @if(GroupPermission::usercan('view','fakenews')) --}}
                                                    {{-- @endif --}}
                                                    @if(GroupPermission::usercan('view','fakenews'))
                                                    <!-- route does not work...-->
                                                    @role('Manager')
                                                        <a href="{{ route('fakenews.show.manage',['id' => $report->id]) }}"
                                                            class="btn btn-sm btn-default">
                                                            <i class="fa fa-eye" aria-hidden="true"></i> View
                                                        </a>
                                                    @endrole
                                                    @endif
                                                    @if(GroupPermission::usercan('edit','fakenews'))
                                                        <a href="{{ route('show.fakenews',['id' => $report->id]) }}"
                                                            class="btn btn-sm btn-default">
                                                            <i class="fa fa-eye" aria-hidden="true"></i> Investigate
                                                        </a>
                                                    @endif
                                                    {{-- @if($report->status=="Closed") --}}
                                                    @if(GroupPermission::usercan('delete','fakenews'))
                                                        <button class="btn btn-danger" id="delete-this"
                                                                data-target="fakenews" data-id="{{ $report->id }}"
                                                                data-place="home" data-content="{{Auth::user()->id}}">
                                                            <span class="glyphicon glyphicon-trash"></span>Delete
                                                        </button>
                                                    @endif
                                                    {{-- @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p> Nothing yet</p>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            @endif <!-- end if GroupPermission::usercan('view','hotline') -->

            </div>
        </div>





        @endsection

        @section('scripts')

            <script>
                $(window).on('load', function () {
                    $('#Table').removeAttr('style');
                })

            </script>
            <script type="text/javascript" src="{{ asset('js/calls/modals.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/calls/calls.js') }}"></script>
            <script>
                $(document).ready(function () {
                    $('.js-example-basic-multiple').select2();
                    $(".top").tooltip({
                        placement: "top"
                    });
                });</script>
@endsection
