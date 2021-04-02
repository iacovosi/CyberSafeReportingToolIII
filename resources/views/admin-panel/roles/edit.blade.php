@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">


                <a href="{{ route('roles') }}" class="btn btn-default">Back</a>
                <a href="#" class="btn btn-primary" id="update-this" data-target="roles" data-id="{{ $role->id }}">Update</a>
                <a href="{{ route('delete-role',['role' => $role->id]) }}" class="btn btn-danger pull-right">Delete</a>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Info</a></li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="panel panel-default">
                            <form class="" id="submit-form">
                                <div class="panel-heading">{{ $role->name}}</div>
                                <div class="panel-body">
                                    <form class="" action="" method="post">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" value="{{ $role->name }}"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="display_name">Email</label>
                                            <input type="text" name="display_name" value="{{ $role->display_name }}"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <input type="text" name="description" value="{{ $role->description}}"
                                                   class="form-control">
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @include('partials.errors')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('/js/calls/calls.js')}}"></script>
@endsection
