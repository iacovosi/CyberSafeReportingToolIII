@extends('layouts.master')

@section('content')

<div class="container-fluid">

    {{-- @include('partials.info') --}}

    <p>@lang('translations.formHelpline.intro')</p>

    <form method="post" action=" {{ route('save-helpline') }}" class="userReportForm helplineForm">

        <!-- Resource Type -->
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">@lang('translations.form.resource_type_legend') *</legend>
            <div class="form-group">
                <label for="resource_type">@lang('translations.form.resource_type_label')</label>
                @foreach($resource_types as $resource_type)
                    @if($resource_type->name != "irrelevant") 
                        <div class="radio">
                            <label>
                                <input type="radio" name="resource_type" value="{{ $resource_type->name }}" @if (old('resource_type') == $resource_type->name) checked  @endif>
                                {{ $resource_type->display_name_en }}
                            </label>
                        </div>
                    @endif
                @endforeach
                <span class="text-danger">{{ $errors->first('resource_type') }}</span>
            </div>
            <!-- Optional url for resource -->
            <div class="form-group" id="resource-url">
                <label for="resource_url">@lang('translations.form.resource_url_label') *</label>
                <input type="url" name="resource_url" placeholder="http://example.com" class="form-control {{ ($errors->has('resource_url')) ? 'alert-danger'  :''}}" value="{{ old('resource_url') }}">
                <span class="text-danger">{{ $errors->first('resource_url') }}</span>
            </div>
        </fieldset>

        <!-- Content Type -->
        <fieldset class="scheduler-border">
            <legend class="scheduler-border" data-toggle="popover"  data-trigger="hover" data-placement="bottom" data-content="">@lang('translations.form.content_type_legend') *</legend>
            <div class="form-group">
                <label for="content_type">@lang('translations.form.content_type_label')</label>
                @foreach($content_types as $content_type)
                    @if ($content_type->is_for == "helpline" && $content_type->display_name_en != "_IRRELEVANT_" )                    
                        <div class="radio">
                            <label data-toggle="tooltip" data-placement="top">
                                <input type="radio" name="content_type" value="{{ $content_type->name }}" @if (old('content_type') == $content_type->name) checked  @endif>
                                {{ $content_type->display_name_en }} <i class="fa fa-info-circle" aria-hidden="true"  data-toggle="popover"  data-trigger="hover" data-placement="bottom" data-content="{{ $content_type->description_gr }}"></i>
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
            <span class="text-danger">{{ $errors->first('content_type') }}</span>
        </fieldset>

        <!-- Comments -->
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">@lang('translations.form.comments_legend')</legend>
            <div class="form-group">
                <textarea type="text" name="comments" class="form-control" id="comments" rows="5" maxlength="2500" placeholder="@lang('translations.form.comments_placeholder')">{{ old('comments') }}</textarea>
                <div class="help-block">Maximum 2500 characters <span class="notification"></span></div>
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

        <input type="hidden" name="is_it_hotline" value="false">

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
