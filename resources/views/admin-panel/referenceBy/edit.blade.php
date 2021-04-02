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
            <form class="form-horizontal" method="POST" action="/referenceBy/{{$referenceBy->id}}">
                <input type="hidden" name="_method" value="PUT" />

                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{$referenceBy->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="display_name_en" class="col-sm-2 control-label">English name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="display_name_en" value="{{$referenceBy->display_name_en}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description_en" class="col-sm-2 control-label">English description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description_en">{{$referenceBy->description_en}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="display_name_gr" class="col-sm-2 control-label">Greek name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="display_name_gr" value="{{$referenceBy->display_name_gr}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description_gr" class="col-sm-2 control-label">Greek description</label>
                    <div class="col-sm-10">
                            <textarea class="form-control" rows="3" name="description_gr">{{$referenceBy->description_gr}}</textarea>
                    </div>
                </div>                
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                        </button>
                        <a href="{{route('referenceBy.index')}}" class="btn btn-default">
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