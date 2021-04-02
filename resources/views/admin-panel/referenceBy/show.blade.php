@extends('layouts.app') 

@section('content')
@if(GroupPermission::usercan('view','content'))
<div class="container">

    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            <h4 class="pull-left"><i class="fa fa-eye" aria-hidden="true"></i> Show Item</h4>
        </div>

        <div class="panel-body">
            <form class="form-horizontal">

                {{ csrf_field() }}

                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{$referenceBy->name}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">English name</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{$referenceBy->display_name_en}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">English description</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{$referenceBy->description_en}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Greek name</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{$referenceBy->display_name_gr}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Greek description</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{$referenceBy->description_gr}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{route('referenceBy.index')}}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
    </div>

</div>
@endif
@endsection
