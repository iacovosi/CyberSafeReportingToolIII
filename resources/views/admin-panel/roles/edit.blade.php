@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <a href="{{ route('roles.index') }}" class="btn btn-default">Back</a>
                <a id="delete-this" data-target="roles" data-id="{{ $role->id }}" class="btn btn-danger pull-right">Delete</a>
                <br>
                <br>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{ $role->name}}</div>
                                <div class="panel-body">
                                    <form class="" action="{{route('roles.update', $role->id)}}" method="POST">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="name">Role Name</label>
                                            <input type="text" name="name" value="{{ $role->name }}" class="form-control">
                                        </div>
                                        <legend>Permissions</legend>
                                        <div class="row">
                                            @foreach($groups as $group)
                                                <div class="control-label col-md-2">
                                                    <b>{{ $group->name }}</b>
                                                </div>
                                                
                                                <div class="col-md-10" name="{{ $group->name }}">
                                                    @foreach($permissions as $permission)
                                                        <label class="checkbox-inline"><input type="checkbox" name="{{ $permission .'_'.$group->name }}" @if($role->hasPermissionTo($permission .'_'.$group->name)) checked @endif>
                                                            {{ $permission }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                        <br>
                                        <div class="row col-md-5">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form> 
                                </div>
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
