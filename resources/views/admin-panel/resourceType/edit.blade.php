@extends('layouts.app') 

@section('content')
@if(GroupPermission::usercan('view','content'))
<div class="container">

    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            <h4 class="pull-left"><i class="fa fa-pencil" aria-hidden="true"></i> Edit item</h4>
        </div>

        <div class="panel-body">

            {{--  
                To call the update() method, you must make a PUT request. 
                But HTML forms can't make PUT requests. 
                So, Laravel provids a way to mimick a PUT request with forms  
            --}}
            <form class="form-horizontal" method="POST" action="/resourceType/{{$resourceType->id}}">
                <input type="hidden" name="_method" value="PUT" />

                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{$resourceType->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="display_name_en" class="col-sm-2 control-label">English name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="display_name_en" value="{{$resourceType->display_name_en}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="display_name_gr" class="col-sm-2 control-label">Greek name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="display_name_gr" value="{{$resourceType->display_name_gr}}">
                    </div>
                </div>                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                        </button>
                        <a href="{{route('resourceType.index')}}" class="btn btn-default">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Cancel
                        </a>
                    </div>
                </div>
 
                @include('partials.errors')

            </form>
        </div>

    </div>

</div>
@endif
@endsection