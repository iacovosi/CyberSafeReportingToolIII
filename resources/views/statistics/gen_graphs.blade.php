@extends('layouts.app') 

@section('content')

<div class="container report-details" id="gen_charts">

    <div class="row">
        <div class="col-md-12">
            <form method="GET" action="{{ route('gen.charts') }}" id="submit-form" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="pull-left">Graph and Chart Generator</h4>
                        <div class="pull-right form-actions">
                            @include('partials.errors')
                            <a href="/home" class="btn btn-default"><i
                                        class="fa fa-times" aria-hidden="true"></i> Back to Home View</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-eye-o" aria-hidden="true"></i> Generate Graphs 
                                </button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!------------------>
                        <!-- chart param  -->
                        <!------------------>
                        <fieldset>
                            <legend>Chart Parameters</legend>
                            <fieldset class="form-group" >
                                <!-- from date -->
                                <label for="pre_range" class="col-sm-2 control-label">Date Range:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="pre_range" placeholder = 'Plaese select a choice...'>
                                        <option value="" disabled selected>Choose a date range...</option>
                                        <option value="3_months">
                                            Previous 3 months
                                        </option>
                                        <option value="6_months">
                                            Previous 6 months
                                        </option>
                                        <option value="12_months">
                                            Previous 12 months
                                        </option>
                                    </select>
                                </div>
                                <!-- Cust dates-->
                                <label for="cust_choice" class="col-sm-2 control-label">Custom Date Range?:</label>
                                <div class="btn-group col-sm-4" data-toggle="buttons">
                                    <label for="cust_choice" class="btn btn-default">
                                    <input type="radio" class='btn btn-default form-control' name="cust_choice" value='yes' id="cust_choice_yes">Yes</input>
                                    </label>
                                    <label for="cust_choice" class="btn btn-default">
                                    <input type="radio" class='btn btn-default form-control' name="cust_choice" value='no' id="cust_choice_no">No</input>
                                    </label>
                                </div>
                            </fieldset>
                         
                                <fieldset class="form-group" id = 'specific_date'>
                                    <!-- from date -->
                                    <label for="from_date" class="col-sm-2 control-label">From:</label>
                                    <div class="col-sm-4">
                                            <input type="date" class="form-control" name = 'from_date' value={{ old('from_date') }} required>
                                    </div>
                                    <!-- to date -->
                                    <label for="to_date" class="col-sm-2 control-label">To:</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name = 'to_date'value={{ old('to_date') }} required>
                                    </div>
                                </fieldset>
        
                            <fieldset class="form-group">
                                <!-- Data choice -->
                                <label for="data_sellection" class="col-sm-2 control-label">Data Sellection:</label>
                                <div class="btn-group col-sm-4" data-toggle="buttons">
                                    <label for="data_sellection" class="btn btn-default">
                                    <input type="radio" class='btn btn-default form-control' name="data_sellection" value='helpline' id="helpline_sel">Helpline</input>
                                    </label>
                                    <label for="data_sellection" class="btn btn-default">
                                    <input type="radio" class="btn btn-default form-control" name="data_sellection" value='hotline 'id="hotline_sel">Hotline</input>
                                    </label>
                                    <label for="data_sellection" class="btn btn-default">
                                    <input type="radio" class="btn btn-default form-control" name="data_sellection" value='fakenews 'id="fakenews_sel">Fakenews</input>
                                    </label>
                                </div>
                                
                                <!-- Chart types -->
                                <label for="chart_type" class="col-sm-2 control-label">Chart Type:</label>
                                <div class="col-sm-4">
                                    @foreach($report_chart_types as $chart_type)
                                    <span title="{{ $chart_type->description }}">
                                    <input type="checkbox" name="chart_type[]" value='{{ $chart_type->typename }}'> {{ $chart_type->typename }}
                                    </span>
                                    <br>
                                    @endforeach
                                    <span title="All availabe chart are generated">
                                    <input type="checkbox" name="chart_type[]" value ='all' checked> All of the Above
                                    </span>
                                </div>
                            </fieldset>
                            <fieldset class="form-group">
                            <div class="col-sm-12">
                                
                            </div>
                            </fieldsat>
                        </fieldset>    
                    </div>
                </div>    
            </form>
        </div>
    </div> 

</div>
@if (count($charts)!=0)
<div class="container report-details" id="gen_charts">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="pull-left">Graph and Chart Results @if ($service!=null)   <b>[ Showing results for the {{$service}} service, on the dates of {{$start_date}} to {{$end_date}} ] </b>@endif</h4>
                </div>
                <div class="panel-body">
                    <!------------------>
                    <!-- chart result -->
                    <!------------------>
                    <fieldset>

                        @foreach($charts as $chart)
                        <fieldset class="form-group">
                        <div class="col-sm-1">
                        </div>
                        <div class="col-sm-10">
                        {!! $chart->container() !!}
                        {!! $chart->script() !!}
                        </div>
                        <div class="col-sm-1">
                        </div>
                        </fieldset>
                        @endforeach

                    </fieldset>    
                </div>
            </div>    
        </div>
    </div> 

</div>
@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Enable all popovers in the document
        $('[data-toggle="popover"]').popover();

        // Show/hide the #website-info element(s) on change event and on page-load
        $('#specific_date').hide();


        $('input[name="cust_choice"]').on('change', function() {
            if(this.value === "yes") {
                $('#specific_date').show();
            }else if(this.value === "no") {
                $('#specific_date').hide();
            }
        }).change();


	});


</script>
@endsection
