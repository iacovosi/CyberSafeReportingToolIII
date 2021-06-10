@extends('layouts.bare') 

@section('content')
<div class="container">
    <div class="panel panel-default" >
    <div class="panel-heading clearfix">
        <h4 class="pull-left"><i class="fa fa-bar-chart" aria-hidden="true"></i> Evaluated Reports</h4>
    </div>
    <div class="panel-body">
        <?php $img_cntr = 0 ?>
        @foreach($fakenews as $report)
        <div>
            <fieldset>
                <legend>Report on {{$report['fakenews_source_type']}} news evaluated at {{$report['updated_at']}}</legend>
                <fieldset class="form-group">
                    <div class="col-sm-12 panel">
                        <h4>This {{$report['fakenews_source_type']}} resource report was evaluated as <b>{{$report['fakenews_type']}}</b> and given an assurance rating of <b>{{$report['evaluation']}} out of 100.</b></h4>
                    </div>
                </fieldset>
                <fieldset class="form-group">     
                    <div class="col-sm-12 panel">
                    <?php $comments = Crypt::decrypt($report['comments']); ?>
                    <h4>Reporter's comments:</h4> {{$comments}}
                    </div>
                </fieldset>      
                <fieldset class="form-group"> 
                    <div class="col-sm-12 panel">
                    <h4>Evaluator's Comments and Actions:</h4>{{$report['actions']}}
                    </div>
                </fieldset>  
                    @if($report['img_upload']==1)
                    <fieldset class="form-group"> 
                        <div class="col-sm-12 panel">
                        <h4>Picture Evidence Provided:</h4>
                        </div>
                    </fieldset>  
                    
                        @foreach($img_array[$img_cntr] as $img_name)
                            <fieldset class="form-group"> 
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-4">
                                <img class ="img-thumbnail"  src="{{ asset('storage/uploaded_images/' . $img_name) }}" 
                                alt="image is not showable." title="{{$img_name}}" id='evidence_img'>
                                </div>
                                <div class="col-sm-4">
                                </div>
                            </fieldset>
                        @endforeach
                        <?php $img_cntr = $img_cntr + 1?>
                    @endif
                  
            </fieldset>  
        </div>
        @endforeach
        <fieldset class="form-group"> 
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
        </div>
        <div class="col-sm-2.5">
        {{ $fakenews->links() }}
        </div>
        
        </fieldset>
                                 
    </div>
</div>
@endsection



