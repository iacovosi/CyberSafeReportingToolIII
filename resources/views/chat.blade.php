@extends('layouts.external')

@section('content')
<div class="container-fluid chat-container chat-ui">

    <div class="out-of-service alert alert-warning" style="display: none;">
        @lang('translations.chat.operator_not_working_hours')
    </div>

    <div class="row">
        <div class=" col-sm-12">

            <p>@lang('translations.chat.chat_intro')</p>

            <form class="form-inline">

                <div class="panel panel-default" id="chat-customer-panel">

                    <div class="panel-heading clearfix">
                        <h4 class="pull-left"><i class="fa fa-comments-o" aria-hidden="true"></i> Chat</h4>
                        <div class="form-group pull-left">
                            <label class="sr-only" for="chat-customer-name">Name</label>
                            <input type="text" name="chat-customer-name" id="chat-customer-name" class="form-control chat-sender-name" placeholder="@lang('translations.chat.enter_name')">
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="chat"></div>
                    </div> <!-- END - .panel-body -->

                    <div class="panel-footer">
                        <div class="input-group">
                            <textarea class="form-control custom-control" id="chat-customer-msg" rows="3" style="resize:none" name="message" placeholder="@lang('translations.chat.enter_message')"></textarea>     
                            <span class="input-group-addon btn btn-primary" id="chat-customer-send-msg">Send</span>
                        </div>                        
                        {{-- <div class="input-group">
                            <input id="chat-customer-msg" type="text" class="form-control input-sm"
                                    placeholder="@lang('translations.chat.enter_message')" name="message"
                                    style="color:#000; font-size: 17px; font-weight: 500;"/>

                            <span class="input-group-btn">
                                <button class="btn btn-warning btn-sm" id="chat-customer-send-msg">
                                    @lang('translations.chat.send_button')
                                </button>
                            </span>
                        </div> --}}

                            {{-- <textarea class="autofit"></textarea>
                            
                            <span class="input-group-btn">
                                <button class="btn btn-warning btn-sm" id="chat-customer-send-msg">
                                    @lang('translations.chat.send_button')
                                </button>
                            </span> --}}

                    </div> <!-- END - .panel-footer -->
                </div> <!-- END - .panel -->
            </form>

        </div>
    </div>

    @include('partials.errors')
</div>
@endsection

@section('scripts')

    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    {{--<script src="{{ asset('js/app.js') }}"></script>--}}
    <script src="{{ asset('js/jalerts.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}" charset="utf-8"></script>
    
    <script>
        $(function () {
            if( isWorkingHour(new Date()) ){
                isAnyoneOnline((typeof sessionStorage.chat_id != 'undefined') ? sessionStorage.chat_id : null);
            } else {
                $('.out-of-service').css('display','block');
                $("#chat-customer-name").attr('disabled',true);
                $('#chat-customer-msg').attr('disabled',true);
                $('#chat-customer-send-msg').addClass('disabled');
            }

            $("#chat-customer-name").keyup(function (e) {
              if( $("#chat-customer-name").val().length > 2) {
                  $("#chat-customer-name").removeClass("alert-danger");
              }
            });

            $("#chat-customer-msg").keyup(function (e) {
              if( $("#chat-customer-msg").val().length > 0) {
                  $("#chat-customer-msg").removeClass("alert-danger");
              }
            });
        });
    </script>

@endsection
