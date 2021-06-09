<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CyberSafety') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/onlinestatus.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/project.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">    
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">


    @yield('links-scripts')
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/el.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/en-gb.js"></script>
    <script type="text/javascript" src = "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" defer ></script>  
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" defer></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" defer></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"defer ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" defer></script>
    


</head>

<body>
    <div id="app">

        
        @include('partials.topnavbar')
        
        <div class="row">
            
            @if(Auth::check())
                @if (\App\GroupPermission::usercan('view','chat'))

                    {{-- Chat ---}}  
                    <input type="hidden" class="chat-sender-name" value="{{ Auth::user()->name }}">

                    <div class="inner-chat" style="display:none">
                        <img src="{{ asset('images/chat.png')}}" alt="" id="notification-chat-image" style="position: fixed; right: 10px; z-index: 10; width: 90px;">
                    </div>

                    <div class="panel panel-primary" id="chat-operator-panel" >

                        <div class="panel-heading" id="chat-operator-header">
                            Click here to move!
                            <div class="btn-group pull-right">
                                <a type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#collapseContent">
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                </a>
                                <a type="button" class=" btn btn-default btn-xs" data-container="body" data-toggle="popover" data-placement="left" id="close-pop">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </div>
                        </div>
                        
                        <div class="panel-collapse collapse in" id="collapseContent" aria-labelledby="headingOne">
                            <div class="panel-body" id="chat-operator-body">
                                <article>

                                    <span class="inner-chatroom" id="inner-chatroom">
                                    </span>
                                </article>
                            </div>
                            <div class="panel-footer">
                                <div class="input-group">
                                    <input id="reply-input" type="text" class="form-control input-sm" placeholder="Type your message here..." name="message"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-warning btn-sm" id="reply-chat">
                                            Send
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(GroupPermission::usercan('view','online_users'))
                    {{-- Online Users ---}}        
                    <div id="chat" class="animated-chat tada" onclick="loadChatbox()">Online</div>
                        <div class="chatbox" id="chatbox">
                            <h4>CyberSafety Online Users</h4>
                    
                            <div style="width: 280px; height: 450px; overflow: hidden; margin: auto; padding: 0;">
                                <div style="width: 280px; height: 450px; overflow: hidden; margin: auto; padding: 0; border:0;">
                                    <div id="chat-content">
                                    </div>
                                </div>
                            </div>
                            <div id="close-chat" onclick="closeChatbox()">&times;</div>
                            <div id="minim-chat" onclick="minimChatbox()"><span class="minim-button">&minus;</span></div>
                            <div id="maxi-chat" onclick="loadChatbox()"><span class="maxi-button">&plus;</span></div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        

        @yield('content')

    </div>

    <!-- Scripts -->
    @yield('scripts')


   
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>        
    <script src="{{ asset('js/select2.full.min.js') }}" charset="utf-8"></script>
    
    @if(Auth::check())
        <script type="text/javascript">
        
            $( function() {
                $( "#chat-operator-panel" ).draggable();
            } );

            $(document).on('click','#notification-chat-image',function(){
                $('#chat-operator-panel').css('display','block');
                $('#notification-chat-image').css('display','none');
                var id = "{{ Auth::user()->id }}";
                // var name = "{{ Auth::user()->name }}";
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('input[name=_token]').val(),
                    },
                    url: '/chatroom/'+id,
                    type: 'POST',
                    data:{ 
                        receiver : id, 
                        // operatorName : name,
                    },
                    success: function(data){
                    },
                });
            });

            $( "#reply-input" ).focus(function() {
                $('#chat-operator-panel .panel-body').scrollTop($('#chat-operator-panel .panel-body')[0].scrollHeight);
            });

            $(document).ready(function() {
                $('[data-toggle="popover"]').popover({
                    trigger:'click',
                    animation:true,
                    content: '<p>Are you sure you want to terminate this discussion?</p> <a href="#" id="destroy-session" class="btn btn-success" onclick="$(&quot;#close-pop&quot;).popover(&quot;hide&quot;);">Yes</a> <a type="button" id="close" class="btn btn-danger" onclick="$(&quot;#close-pop&quot;).popover(&quot;hide&quot;);">No &times;</a>',
                    html: true,
                });

                $(document).on('click','#reply-chat',function(){
                    var sender = "{{ Auth::user()->name }}";
                    var replyData = $('#reply-input').val();
                    $.ajax({
                        url: '/chatroom',
                        type: 'GET',
                        success: function(data) {
                            $('#reply-input').val('');
                            populate_reply(replyData, data.chat_id, sender);
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    });
                });

                $(document).on('click','#destroy-session',function(){
                    $.ajax({
                        url: '/chatroom',
                        type: 'GET',
                        success: function(data) {
                            close_sesion(data.chat_id);
                            $('#chat-operator-panel').css('display','none');
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    });
                })


                setTimeout(function() {
                    var id = "{{ Auth::user()->id }}";
                    var name = "{{ Auth::user()->name }}";
                    $.ajax({
                        url: '/chatroom',
                        type: 'GET',
                        success: function(data) {
                            if(data.status =='established'){
                                // console.log(data);
                                append_data_to_chatrooms(data.chat_id);
                                if(data.receiver == '0'){
                                    $('.inner-chat').css('display','block');
                                    $('#notification-chat-image').css('display','block');
                                    return;
                                } else if (data.status == 'established' && data.receiver != parseInt(id) ) {
                                    $('.inner-chat').css('display','none');
                                } else if (data.status == 'established' && data.receiver == parseInt(id)) {
                                    // $('#notification-chat-image').css('display','block');
                                    $('.inner-chat').css('display','block');
                                }
                            }
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    });
                },
                3000);
            });

            // run every 20 seconds
            setInterval(function() {
                loadOnlineUsers();
            }, 20000);

            // this will be used to get the online users every 20 seconds and serve as a heart beat.
            const loadOnlineUsers = () =>{
                $.ajax({
                    url: '/online',
                    type: 'GET',
                    success: function(data) {
                        $('#chat-content').html('');
                        data.forEach(element => {
                            document.getElementById("chat-content").innerHTML+=`<br><span class="dot"></span> ${element.name}`
                        });
                    },
                    error: function(data) {
                        // console.log(data);
                    }
                });
            }

            const loadChatbox = () => {
                $('#minim-chat').css('display','block');
                $('#maxi-chat').css('display','none');
                $('#chatbox').css('margin','0');
                loadOnlineUsers();
            }


            const closeChatbox = () => {
                $('#chatbox').css('margin','0 0 -1500px 0');
            }

            const minimChatbox = () => {
                $('#minim-chat').css('display','none');
                $('#maxi-chat').css('display','block');
                $('#chatbox').css('margin','0 0 -460px 0');
            }
            
        </script>
    @endif

  

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
</body>
</html>
