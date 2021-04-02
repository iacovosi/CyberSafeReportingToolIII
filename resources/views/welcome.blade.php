<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>CyberSafety</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/project.css') }} ">
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <!-- @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif -->
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">

				{{ config('app.name', 'CyberSafety')}}
                </div>

                <div class="links">

                  
                </div>

            </div>

        </div>

        <div class="col-md-3" style="position:fixed; bottom:10px; right: 10px;">
            <div class="panel panel-primary" id="chat-panel">
                <div class="panel-heading" id="accordion">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                    <input type="name" name="userName" value="" id="userName" placeholder="Enter your name" style="color:#000; font-size: 17px; font-weight: 500;">
                    <div class="btn-group pull-right">

                        <a type="button" class="btn btn-success btn-xs" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>

                    </div>
                </div>
            <div class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <ul class="chat">
                        <li class="left clearfix"><span class="chat-img pull-left">

                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">Hello</strong> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span></small>
                                </div>
                                <p>
                                   Enter your name first, type your message and click send. We will reply as soon as possible
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." name="message" style="color:#000; font-size: 17px; font-weight: 500;"/>
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat">
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
            </div>
        </div>

    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
      <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}" charset="utf-8"></script>
    <script>
          $( function() {
            $( "#chat-panel" ).draggable();
          } );
    </script>
    </body>
</html>
