@extends('layouts.app') 
    
    @section('content')

    <div class="container">
 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="pull-left">Automated Archive Hotline/Helpline</h4>
                    </div>

                    <div class="panel-body">
                    @include('partials.errors')
                    <form action="{{route('settingsController.store')}}" class="form-inline results-filters" method="POST" id="submit-form">
                        <label for="deleteAfterHelplineHotline">Archive closed hotline/helpline reports after (in months):</label>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input {{GroupPermission::usercan('edit','settings')?'':'disabled'}} name="deleteAfterHelplineHotline" type='number' value="{{$delete_after_helpline_hotline}}" class="form-control form-inline" />
                        </div>
                        <div class="form-group">
                            @if(GroupPermission::usercan('edit','settings'))
                                <button type="submit" class="btn btn-primary">
                                    UPDATE
                                </button>
                            @endif
                        </div>
                        <br><br>
                        Input must be a possitive integer, you can use 0 to disable this feature.
                    </form>
                </div>
                </div>    
            </div>
        </div>
    </div> 

    @endsection