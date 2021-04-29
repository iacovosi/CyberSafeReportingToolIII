@extends('layouts.master')

@section('content')

<div class="container-fluid">

    {{-- @include('partials.info') --}}

    <!-- <p>@lang('translations.formHelpline.intro')</p> -->
    <p>FAKENEWS PLACEHOLDER</p> 
    <form method="post" action=" {{ route('save-fakenews') }}" class="userReportForm fakenewsForm" enctype = 'multipart/form-data'>

        <!-- Fakenews Type -->
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">@lang('translations.form.content_type_legend') *</legend>
            <div class="form-group">
                <label for="fakenews_type">@lang('translations.form.content_type_label')</label>
                @foreach($fakenews_type as $fakenews_type)
                    @if($fakenews_type->typename != "irrelevant") 
                        <div class="radio">
                            <label>
                                <input type="radio" name="fakenews_type" value="{{ $fakenews_type->typename }}" @if (old('fakenews_type') == $fakenews_type->typename) checked  @endif > 
                                
                                {{ $fakenews_type->typename_en }}
                                 </input>
                            </label>
                        </div>
                    @endif
                @endforeach

                <span class="text-danger">{{ $errors->first('fakenews_type') }}</span>

            </div>
        </fieldset>
        <!-- uploading images-->
        <fieldset class="scheduler-border">
            <legend class="scheduler-border"> Upload images placeholder</legend>
            <div class="form-group">
                <input required type="file" class="form-control" name="images[]" multiple placeholder="address" >
<!--                 <div class="form-group"
                    <button type="submit" class="btn btn-success" value="@lang('translations.form.upload')">@lang('translations.form.upload') </button>
                </div> -->
            </div>
        </fieldset>

        <!-- Source document -->
        <fieldset class="scheduler-border">
        <legend class="scheduler-border">@lang('translations.form.comments_legend') Source document Info</legend>
            <!-- Title of news -->
            <div class="form-group" id="news_title">
                <label for="title">@lang('translations.form.title') *</label>
                <input type="text" name="title" class="form-control" value=></input>
                <span class="text-danger">{{ $errors->first('resource_url') }}</span>
            </div>
            <div class="form-group">
                <label for="source_document">@lang('translations.form.title') Source document *</label>
                <textarea type="text" name="source_document" class="form-control" id="source_document" rows="5" maxlength="10000" placeholder="@lang('translations.form.comments_placeholder')">{{ old('comments') }}</textarea>
                <div class="help-block">10000 Maximum  characters<span class="notification"></span></div>
            </div>
            <!-- source of news -->
            <div class="form-group" id="source">
                <label for="source">@lang('translations.form.source') *</label>
                <input type="text" name="source" class="form-control" value=></input>
            </div>
            <!-- publication date -->
            <div class="form-group">
                <label for="publication_date">@lang('translations.form.source') publication date *</label>
                <input type="date" name="publication_date" class="form-control" id="publication_date"></input>
                <div class="help-block"> <span class="notification"></span></div>
            </div>
            <!-- URL source -->
            <div class="form-group">
                <label for="source_url">@lang('translations.form.source') source url *</label>
                <input type="text" name="source_url" class="form-control" id="source_url"></input>
                <span class="text-danger">{{ $errors->first('source_url') }}</span>
                <div class="help-block"> <span class="notification"></span></div>
            </div>
        </fieldset>

        <fieldset class="scheduler-border">
        <legend class="scheduler-border">Area info</legend>
            <!-- Country of news -->
            <div class="form-group" id="country">
                <label for="country">Country*</label>
                <input type="text" name="country" class="form-control" value=></input>
                <span class="text-danger">{{ $errors->first('resource_url') }}</span>
            </div>
            <!-- Town -->
            <div class="form-group" id="town">
                <label for="town">Town</label>
                <input type="text" name="town" class="form-control" id="town"></input>
                <div class="help-block"> <span class="notification"></span></div>
            </div>
            <!-- Specific adresss -->
            <div class="form-group" id="specific_area_address">
                <label for="address">Address</label>
                <input type="text" name="specific_area_address" class="form-control" id="specific_area_address"></input>
                <div class="help-block"> <span class="notification"></span></div>
            </div>

        </filedset>
        
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
        $('#resource-url').hide();
        $('input[name="resource_type"]').change(function() {
            if((this.value != "mobile") && this.checked) {
                $('#resource-url').show();
            } else if((this.value == "mobile") && this.checked) {
                $('#resource-url').hide();
            }
        }).change();

        $('input[name="personal_data"]').on('change', function() {
            $('#additional-info').toggle((this.value == "true") && this.checked);
        }).change();

        $('textarea#comments').on('keyup',function(){
            var charMax = 2500;
            var charCount = $(this).val().length;
            var charLeft = charMax - charCount;
            if (charLeft <= 2000) {
                $(".notification").text(" (" + charLeft + " remaining)");
            } 
        });
	});

    // Make iframe automatically adjust height according to the contents in it using javascript (Support Cross-Domain)
    setInterval(function() {
        window.top.postMessage(document.body.scrollHeight, "https://www.cybersafety.cy/helpline-report");
    }, 500);
</script>
@endsection
