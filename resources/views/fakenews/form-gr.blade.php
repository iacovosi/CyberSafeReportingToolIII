@extends('layouts.master')

@section('content')

<div class="container-fluid">

    {{-- @include('partials.info') --}}

    <!-- <p>@lang('translations.formHelpline.intro')</p> -->
    <p>@lang('translations.form.fakenews_intro')</p> 

    <form method="post" action=" {{ route('save-fakenews') }}" class="userReportForm fakenewsForm" enctype = 'multipart/form-data'>
        <fieldset class="scheduler-border">
            <div class="form-group">
                <label for="fakenews_source_type">Source Type (PLACEHOLDER)</label>
                <br/>
                <div class="btn-group" data-toggle="buttons">
                    @foreach($fakenews_source_type as $type)
                    <label class="btn btn-default @if (old('fakenews_source_type') == $type->typename) active  @endif">
                        <input type="radio" name="fakenews_source_type" value="{{$type->typename}}" @if (old('fakenews_source_type') == $type->typename) checked  @endif>
                        {{$type->typename_gr}}
                    </label>
                    @endforeach
                </div>
            </div>
        </fieldset>

        <!-- Internet route -->
        <fieldset class="scheduler-border" id ='source_url'>
            <legend class="scheduler-border">@lang('translations.form.internet_route')</legend>
            <!-- URL source -->
            <div class="form-group">
                <label for="source_url">@lang('translations.form.resource_url_label') *</label>
                <input type="text" name="source_url" class="form-control" id="source_url" value={{ old('source_url') }}></input>
                <span class="text-danger">{{ $errors->first('source_url') }}</span>
                <div class="help-block"></div>
            </div>
            <!-- Title of news -->
            <div class="form-group">
                <label for="title">@lang('translations.form.title') *</label>
                <input type="text" name="title" class="form-control" id="title" value={{ old('title') }}></input>
                <span class="text-danger">{{ $errors->first('resource_url') }}</span>
            </div>
            <!-- problematic document or extract of news -->
            <div class="form-group">
                <label for="source_document">@lang('translations.form.source_doc')</label>
                <textarea type="text" name="source_document" class="form-control" id="source_document" rows="10" maxlength="10000" placeholder="@lang('translations.form.source_doc_placeholder')" >{{ old('source_document') }}</textarea>
                <div class="help-block">10000 Maximum characters<span class="notification_source_doc"></span></div>
            </div>

        </fieldset>

   
        <!-- TV route -->
        <fieldset class="scheduler-border" id ='tv_channel'>
            <legend class="scheduler-border">@lang('translations.form.tv_route')</legend>
            <!-- TV channel -->
            <div class="form-group">
                <label for="tv_channel">@lang('translations.form.tv_channel')*</label>
                <input type="text" name="tv_channel" class="form-control" id="tv_channel" value={{ old('tv_channel') }}></input>
                <div class="help-block"></div>
            </div>
            <!-- TV channel progarm title -->
            <div class="form-group">
                <label for="tv_prog_title">@lang('translations.form.tv_prog_title')*</label>
                <input type="text" name="tv_prog_title" class="form-control" id="tv_prog_title" value={{ old('tv_prog_title') }}></input>
                <div class="help-block"></div>
            </div>
            <!-- publication time -->
            <div class="form-group">
                <label for="publication_time">@lang('translations.form.publication_time')</label>
                <input type="time" name="publication_time" class="form-control" id="time" value={{ old('publication_time') }}></input>
                <div class="help-block"> </div>
            </div>
        </fieldset>


        <!-- Radio route -->
        <fieldset class="scheduler-border" id ='radio'>
            <legend class="scheduler-border">@lang('translations.form.radio_route')</legend>
            <div class="row">
                <div class="col-sm-6">
                    <!-- Radio channel station -->
                    <div class="form-group">
                        <label for="radio_station">@lang('translations.form.radio_station')</label>
                        <input type="text" name="radio_station" class="form-control" id="radio_station" value={{ old('radio_station') }}></input>
                        <div class="help-block"> </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Radio channel frequency -->
                    <div class="form-group">
                        <label for="radio_freq">@lang('translations.form.radio_station_freq')*</label>
                        <input type="text" name="radio_freq" class="form-control" id="radio_freq" value={{ old('radio_freq') }}></input>
                        <div class="help-block"> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <!-- Country of news -->
                    <div class="form-group" id="country">
                        <label for="country">@lang('translations.form.country')*</label>
                        <input type="text" name="country" class="form-control" value={{ old('country') }}></input>
                        <span class="text-danger">{{ $errors->first('resource_url') }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Town -->
                    <div class="form-group" id="town">
                        <label for="town">@lang('translations.form.town')*</label>
                        <input type="text" name="town" class="form-control" id="town" value={{ old('town') }}></input>
                        <div class="help-block"> </div>
                    </div>
                </div>
            </div>

            <!-- publication time -->
            <div class="form-group">
                <label for="publication_time">@lang('translations.form.publication_time')</label>
                <input type="time" name="publication_time" class="form-control" id="time" value={{ old('publication_time') }}></input>
                <div class="help-block"></div>
            </div>
        </fieldset>

        <!-- Newspaper route -->
        <fieldset class="scheduler-border" id ='newspaper'>
            <legend class="scheduler-border">@lang('translations.form.radio_route')</legend>
            <!-- Newspaper source -->
            <div class="form-group">
                <label for="newspaper_name">Name of Newspaper (PLACEHOLDER) *</label>
                <input type="text" name="newspaper_name" class="form-control" id="newspaper_name" value={{ old('newspaper_name') }}></input>
                <div class="help-block"></div>
            </div>
            <!-- page -->
            <div class="form-group">
                <label for="page_num">@lang('translations.form.page')</label>
                <input type="number" name="page_num" class="form-control" id="page_num" value={{ old('page_num') }}></input>
                <div class="help-block"> </div>
            </div>
        </fieldset>

        <!-- Advertisement/Pamphlet route -->
        <fieldset class="scheduler-border" id ='advertisement_pamphlet'>
            <legend class="scheduler-border">@lang('translations.form.advertisement_route')</legend>
            <!-- Area adresss source -->
            <div class="row">
                <div class="col-sm-6">
                    <!-- Country of news -->
                    <div class="form-group" id="country">
                        <label for="country">@lang('translations.form.country')*</label>
                        <input type="text" name="country" class="form-control" value={{ old('country') }}></input>
                        <span class="text-danger">{{ $errors->first('resource_url') }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Town -->
                    <div class="form-group" id="town">
                        <label for="town">@lang('translations.form.town')*</label>
                        <input type="text" name="town" class="form-control" id="town" value={{ old('town') }}></input>
                        <div class="help-block"> </div>
                    </div>
                </div>
            </div>
            <!-- Specific area -->
            <div class="form-group" id="area_district">
                <label for="address">@lang('translations.form.area_district')</label>
                <input type="text" name="area_district" class="form-control" id="area_district" value={{ old('area_district') }}></input>
                <div class="help-block"> </div>
            </div>
            <!-- Specific adresss -->
            <div class="form-group" id="specific_address">
                <label for="address">@lang('translations.form.specific_address')</label>
                <input type="text" name="specific_address" class="form-control" id="specific_address" value={{ old('specific_address') }}></input>
                <div class="help-block"> </div>
            </div>
            <!-- Report message-->
            <div class="form-group">
            <h3>@lang('translations.form.image_recomendation')</h3>
            </div>
        </fieldset>


        <!-- Other route -->
        <fieldset class="scheduler-border" id ='other'>
            <legend class="scheduler-border">@lang('translations.form.other_route')</legend>
            <!-- specify-->
            <div class="form-group">
                <label for="address">@lang('translations.form.specify')</label>
                <input type="text" name="specific_type" class="form-control" id="specific_type" value={{ old('specific_type') }}></input>
                <div class="help-block"></div>
            </div>
            <!-- Area adresss source -->
            <div class="row">
                <div class="col-sm-6">
                    <!-- Country of news -->
                    <div class="form-group" id="country">
                        <label for="country">@lang('translations.form.country')*</label>
                        <input type="text" name="country" class="form-control" value={{ old('country') }}></input>
                        <span class="text-danger">{{ $errors->first('resource_url') }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Town -->
                    <div class="form-group" id="town">
                        <label for="town">@lang('translations.form.town')*</label>
                        <input type="text" name="town" class="form-control" id="town" value={{ old('town') }}></input>
                        <div class="help-block"> </div>
                    </div>
                </div>
            </div>
            <!-- Specific area -->
            <div class="form-group" id="area_district">
                <label for="address">@lang('translations.form.area_district')</label>
                <input type="text" name="area_district" class="form-control" id="area_district" value={{ old('area_district') }}></input>
                <div class="help-block"> </div>
            </div>
            <!-- Specific adresss -->
            <div class="form-group" id="specific_address">
                <label for="address">@lang('translations.form.specific_address')</label>
                <input type="text" name="specific_address" class="form-control" id="specific_address" value={{ old('specific_address') }}></input>
                <div class="help-block"> </div>
            </div>
            <!-- Report message-->
            <div class="form-group">
            <h3>@lang('translations.form.image_recomendation')</h3>
            </div>
        </fieldset>

        <!-- coments and date route -->
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">@lang('translations.form.comments_date')</legend>
            <!-- Report comments-->
            <div class="form-group">
                <label for="source_document">@lang('translations.form.comments_legend')</label>
                <textarea type="text" name="comments" class="form-control" id="comments" rows="5" maxlength="2000" placeholder="@lang('translations.form.comments_placeholder')" >{{ old('comments') }}</textarea>
                <div class="help-block">2000 Maximum characters<span class="notification"></span></div>
            </div>
            <!-- publication date -->
            <div class="form-group">
                <label for="publication_date">@lang('translations.form.publication_date')</label>
                <input type="date" name="publication_date" class="form-control" id="publication_date" value={{ old('publication_date') }}></input>
                <div class="help-block"> </div>
            </div>
        </fieldset>

        <!-- uploading images-->
        <fieldset class="scheduler-border">
        <legend class="scheduler-border">@lang('translations.form.upload_images_legend')</legend>
            <div class = "form-group">
                <label for = "image_check">@lang('translations.form.image_question')</label>
                <br/>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="img_upload" value="1" @if (old('img_upload')) checked  @endif>
                        Ναί
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="img_upload" value="0" @if (old('img_upload')) checked  @endif>
                        Όχι
                    </label>
                </div>
            </div>
            <div class = "form-group" id = 'img_upload'>
                <input  type="file" class="form-control" name="images[]" multiple placeholder="images only" >
            </div>
        </fieldset>
        


        <!-- Personal Data -->
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">@lang('translations.form.personal_data_legend') *</legend>
            <div class="additional-info-choice">
                <div class="radio">
                    <label>
                        <input type="radio" name="personal_data" value="false" @if (old('personal_data') == 'false') checked  @endif>
                        @lang('translations.form.personal_data_input_false')
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="personal_data" value="true" @if (old('personal_data') == 'true') checked  @endif>
                        @lang('translations.form.personal_data_input_true')
                    </label>
                </div>
            </div>
            <span class="text-danger">{{ $errors->first('personal_data') }}</span>
            <!-- Optional personal data -->
            <div id="additional-info">
                <div class="row">
                    <!-- Name -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">@lang('translations.form.name_label') *</label>
                            <input type="text" name="name" class="form-control  {{ ($errors->has('name')) ? 'alert-danger'  :''}}" value="{{ old('name') }}" placeholder="@lang('translations.form.name_placeholder')">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <!-- Surname -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="surname">@lang('translations.form.surname_label')</label>
                            <input type="text" name="surname" class="form-control" value="{{ old('surname') }}" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Email -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">@lang('translations.form.email_label') **</label>
                            <input type="email" name="email" placeholder="name@example.com" class="form-control  {{ ($errors->has('email')) ? 'alert-danger'  :''}}" value="{{ old('email') }}">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <!-- Phone -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone">@lang('translations.form.phone_label') **</label>
                            <input type="tel" name="phone" placeholder="99123456" class="form-control  {{ ($errors->has('phone')) ? 'alert-danger'  :''}}" id="tel" value="{{ old('phone') }}">
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>
                    </div>
                </div>
                <div class="help-block"><b>** @lang('translations.form.help_block_personal_data')</b></div>
                <div class="row">
                    <!-- Age -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="age">@lang('translations.form.age_label')</label>
                            <br/>
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($age_groups as $age_group)
                                <label class="btn btn-default  @if (old('age') == $age_group->name) active  @endif">
                                    <input type="radio" name="age" value="{{$age_group->name}}" @if (old('age') == $age_group->name) checked  @endif >{{$age_group->display_name_en}}
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Gender -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="gender">@lang('translations.form.gender_label')</label>
                            <br/>
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($genders as $gender)
                                <label class="btn btn-default @if (old('gender') == $gender->name) active  @endif">
                                    <input type="radio" name="gender" value="{{$gender->name}}" @if (old('gender') == $gender->name) checked  @endif>{{$gender->display_name_en}}
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- Authenticity Check -->
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">@lang('translations.form.g_recaptcha_response_legend') *</legend>
            <div class="form-group" width="10%">
                {!! Recaptcha::render() !!}
            </div>
            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
        </fieldset>

        <div class="help-block"><b>* @lang('translations.form.help_block_required')</b></div>


        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="@lang('translations.form.submit')"> {{ csrf_field() }}
        </div>

        <div class="form-group">
            @include('partials.errors')
        </div>

    </form>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Enable all popovers in the document
        $('[data-toggle="popover"]').popover();

        // Show/hide the #website-info element(s) on change event and on page-load
        $('#source_url').hide();
        $('#tv_channel').hide();
        $('#radio').hide();
        $('#newspaper').hide();
        $('#advertisement_pamphlet').hide();
        $('#other').hide();
        $('#img_upload').hide();




        $('input[name="img_upload"]').change(function() {
            if((this.value === "1") && this.checked) {
                $('#img_upload').show();
            } else if((this.value === "0") && this.checked) {
                $('#img_upload').hide();
            }
        }).change();

        $('input[name="fakenews_source_type"]').change(function() {
            if((this.value === "Internet") && this.checked) {
                $('#source_url').show();
                $('#tv_channel').hide();
                $('#radio').hide();
                $('#newspaper').hide();
                $('#advertisement_pamphlet').hide();
                $('#other').hide();
            } else if((this.value === "TV") && this.checked) {
                $('#source_url').hide();
                $('#tv_channel').show();
                $('#radio').hide();
                $('#newspaper').hide();
                $('#advertisement_pamphlet').hide();
                $('#other').hide();
            } else if((this.value === "Radio") && this.checked) {
                $('#source_url').hide();
                $('#tv_channel').hide();
                $('#radio').show();
                $('#newspaper').hide();
                $('#advertisement_pamphlet').hide();
                $('#other').hide();
            }else if((this.value === "Newspaper") && this.checked) {
                $('#source_url').hide();
                $('#tv_channel').hide();
                $('#radio').hide();
                $('#newspaper').show();
                $('#advertisement_pamphlet').hide();
                $('#other').hide();
            }else if((this.value === "Advertising/Pamphlets") && this.checked) {
                $('#source_url').hide();
                $('#tv_channel').hide();
                $('#radio').hide();
                $('#newspaper').hide();
                $('#advertisement_pamphlet').show();
                $('#other').hide();
            }else if((this.value === "Other") && this.checked) {
                $('#source_url').hide();
                $('#tv_channel').hide();
                $('#radio').hide();
                $('#newspaper').hide();
                $('#advertisement_pamphlet').hide();
                $('#other').show();
            }
        }).change();

        $('input[name="personal_data"]').on('change', function() {
            $('#additional-info').toggle((this.value == "true") && this.checked);
        }).change();

        $('textarea#comments').on('keyup',function(){
            var charMax = 2000;
            var charCount = $(this).val().length;
            var charLeft = charMax - charCount;
            if (charLeft <= 1500) {
                $(".notification").text(" (" + charLeft + " remaining)");
            } 
        });
        $('textarea#source_document').on('keyup',function(){
            var charMax = 10000;
            var charCount = $(this).val().length;
            var charLeft = charMax - charCount;
            if (charLeft <= 8000) {
                $(".notification_source_doc").text(" (" + charLeft + " remaining)");
            } 
        });
	});

    // Make iframe automatically adjust height according to the contents in it using javascript (Support Cross-Domain)
    setInterval(function() {
        window.top.postMessage(document.body.scrollHeight, "https://www.cybersafety.cy/helpline-report");
    }, 500);
</script>
@endsection
