
@extends('layouts.app') 
    
@section('content')
<link rel="stylesheet" href="{{ asset('css/tickets.css') }} ">

<div class="container">
    		
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
              <h1>Helpline/Hotline Report #{{$id}}</h1>
            </div>

            <ul class="timeline">
                @foreach ($helplineslog as $log)
                    <li class="timeline-item">
                        <div class="timeline-badge secondary"><i class="glyphicon"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">Status: {{$log->status}} - {{$log->is_it_hotline? 'Hotline': 'Helpline'}} {{$log->forwarded? '(Forwarded)': ''}}</h4>
                                <h5>{{$log->change}}</h5>
                                <h5>Changed by: {{$log->changedBy ? $log->changedBy->name : 'None'}}</h5>
                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{$log->updated_at}}</small></p>
                            </div>
                            <div class="timeline-body">
                                <ul>
                                    <li>User Opened: {{$log->firstOpened ? $log->firstOpened->name : 'None' }}</li>
                                    <li>User Assigned: {{$log->assignedTo ? $log->assignedTo->name : 'None' }}</li>
                                    <li>Content Type: {{$log->content_type ? $log->content_type : 'None' }}</li>
                                </ul>
                        </div>
                        <br>
                        <a href="{{ route('helplinesLogController.show', $log->id) }}" class="btn btn-info">Show more</a>
                        </div>
                    </li>
                @endforeach

                <li class="timeline-item"></li>
            </ul> 
        </div>
    </div>
</div>
@endsection
