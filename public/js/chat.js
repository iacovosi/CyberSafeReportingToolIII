
$(document).ready(function() {
    // console.log(sessionStorage.chat);
    setInterval(function() {
        if (sessionStorage.chat == 'established') {
            append_data_to_chatrooms(sessionStorage.chat_id);
        }
    }, 3000);

    /*
     *   Replying back to the customer.
     */
    $(document).on('click', '#reply-chat', function() {
    });

    /*
     *  Notyfing the logged user that theres a new message pending.
     */
    $(document).on('click', '#notification-chat-image', function() {
        $('#chat-operator').css('display', 'block');
    });

    // Send message Function to check if the user click on chat-customer-send-msg
    // which sends the message with ajax call
    $(document).on('click', '#chat-customer-send-msg', function(event) {
        let chatUserMsg = $('#chat-customer-msg').val();
        let chatUserName = $('#chat-customer-name').val();

        //In case customer has not provided username return
        if (chatUserName.length < 2) {
            event.preventDefault();
            $('#chat-customer-name').addClass('alert-danger');
            $('#chat-customer-name').focus();
            return;
        }

        //In case customer has not provided message
        if (chatUserMsg.length <2 ) {
            event.preventDefault();
            $('#chat-customer-msg').addClass('alert-danger');
            $('#chat-customer-msg').focus();

        // If name and message entered then...
        } else {
            // Remove alerts and disable name field
            name_and_message_entered();
            
            // Get first entry from Chatroom model 
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name=_token]').val(),
                },
                url: '/chatroom',
                type: 'get',
                success: function(data) {
                    // If chat is not occupied by another customer then store to session data the chat id and mark chat as occupied
                    if (sessionStorage.chat != 'established') {
                        sessionStorage.chat_id = Math.floor(Math.random() * (100000 - 10 + 1) + 10);
                        sessionStorage.chat = 'established';
                    }

                    // If sessions chat id dont match chat id initiated then...
                    if (data.chat_id != sessionStorage.chat_id && data.status == 'established'){
                        $('.chat').append(`<p>@lang('translations.chat.operator_busy')</p>`);
                        sessionStorage.chat ='Used';

                    // If sessions chat id is the right one...
                    } else {
                        // Check if the "line" is busy and if not create new(?) Chatroom
                        notify_logged_users();
                        
                        // Add message info to Message model
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': $('input[name=_token]').val(),
                            },
                            url: '/messages',
                            type: 'POST',
                            data: {
                                message: chatUserMsg,
                                username: chatUserName,
                                chat_id: sessionStorage.chat_id
                            },
                            success: function(data) {},
                            error: function(data) {
                                var errors = data.responseJSON;
                            }
                        });

                        append_data_to_chatrooms(sessionStorage.chat_id);                        
                    }
                },
            });
        }
    });
    //end of Sent message

    $(document).on('click','.close-connection',function(){
        sessionStorage.chat = "Closed";
        location.reload();
    });
});


//When the user closes its browser
window.onbeforeunload = function() {
    var chatUserName = $('#chat-customer-name').val();
    $.ajax({
        headers: {
            'X-CSRF-Token': $('input[name=_token]').val(),
        },
        url: '/messages',
        type: 'POST',
        data: {
            message: "Messaging Service: "+ chatUserName + " has closed its browser",
            username: chatUserName,
            chat_id: sessionStorage.chat_id
        }
    });
    sessionStorage.chat ="Closed";
    return null;
};

/*
 * sender = sessionStorage.chat_id
 *
 */
function alert_name(){
    // $.blockUI({ message: 'Please enter your name <br> Παρακαλώ εισάγετε το όνομα σας' , css: {
    //         border: 'none',
    //         padding: '15px',
    //         backgroundColor: '#000',
    //         '-webkit-border-radius': '10px',
    //         '-moz-border-radius': '10px',
    //         opacity: .9,
    //         color: '#fff'
    //     } });
    // setTimeout($.unblockUI, 2000);
}

function name_and_message_entered() {
    $('#chat-customer-name').attr('disabled','disabled');
    $('#chat-customer-name').css({
        'background' :'#3097D1',
        'color' : "#FFF",
        'border' : 'none'
    });

    $('#chat-customer-name').removeClass('alert-danger');
    $('#chat-customer-msg').removeClass('alert-danger');
    $('#chat-customer-msg').val(' ');
}

function notify_logged_users() {
    $.ajax({
        headers: {
            'X-CSRF-Token': $('input[name=_token]').val(),
        },
        url: '/messages/notify',
        type: 'POST',
        data: {
            chat_id: sessionStorage.chat_id,
        },
        success: function(data) {
        },
        error: function(data) {
        }
    })
}

function populate_reply(message,chatid,sender) {
    $.ajax({
        headers: {
            'X-CSRF-Token': $('input[name=_token]').val(),
        },
        url: '/messages',
        type: 'POST',
        data:{
            message : message,
            username : sender,
            chat_id : chatid
        },
        success: function(data){
        },
        error: function(data){
        }
    });
    $('.inner-chatroom').append(`<p>` +sender + ' said: '+ message + `</p>`);
}

function append_data_to_chatrooms(chatid){
    $.ajax({
        headers: {
            'X-CSRF-Token': $('input[name=_token]').val(),
        },
        url: '/messages/' + chatid,
        type: 'GET',
        success: function(data) {
            var nameOfSender = $('.chat-sender-name').val();
            var nameOfSender_previous = '';
            var pullDirection = '';
            var pullDirectionInv = '';
            var lastORnot = '';
            var postedAt = '';

            $('.chat').html('');
            $('.inner-chatroom').html('');

            if(data != 'empty'){
                // for more that one posts...
                if (data.length > 1) {
                    $.each(data, function(i, v) {
                        if (v.sender == nameOfSender) {
                            pullDirection = 'left';
                            pullDirectionInv = 'right';
                            fromto = "from-me"
                        } else {
                            pullDirection = 'right';
                            pullDirectionInv = 'left';
                            fromto = "to-me"
                        }

                        if (i < data.length-1) {
                            // the variable is defined
                            if ( data[i]['sender'] != data[i+1]['sender'])  {
                                lastORnot = 'last';
                            } else {
                                nameOfSender_previous = v.sender;
                                lastORnot = '';
                            }
                            // console.log(i, data[i]['sender'], data[i+1]['sender'], data.length)                            
                        }

                        $('.chat').append(
                            '<div class="chat-msg '+ pullDirection +'">'+
                                '<div class="chat-info clearfix">'+
                                    '<span class="chat-name pull-'+ pullDirection +'">' + v.sender +'</span>'+
                                    '<span class="chat-timestamp pull-'+ pullDirection +'">(' + v.created_at +')</span>'+
                                '</div>'+
                                '<img class="chat-img" src="https://hotline.pi.ac.cy/images/faces/face-0.jpg">'+
                                '<div class="chat-text">' + v.message + '</div>' +
                            '</div>'
                        );
                        $('.inner-chatroom').append(
                            // '<li class="pull-'+ pullDirection +'"><div class="header"><strong class="primary-font sender">' + v.sender + '</strong></div> <p class="chatmessage">' + v.message + '</p></li><div class="clearfix"></div>'
                            '<p class="' + fromto + ' ' + lastORnot + '">' + v.message + '</p>'
                        );
                    });
                // if this is the first post from user...
                } else {
                    pullDirection = 'left';
                    pullDirectionInv = 'right';
                    $('.chat').append(
                        '<div class="chat-msg '+ pullDirection +'">'+
                            '<div class="chat-info clearfix">'+
                                '<span class="chat-name pull-'+ pullDirection +'">' + data[0]['sender'] +' </span>'+
                                '<span class="chat-timestamp pull-'+ pullDirection +'"> (' + data[0]['created_at'] +') </span>'+
                            '</div>'+
                            '<img class="chat-img" src="https://hotline.pi.ac.cy/images/faces/face-0.jpg">'+
                            '<div class="chat-text">' + data[0]['message'] + '</div>' +
                        '</div>'
                    );
                    $('.inner-chatroom').append(
                        // '<li class="pull-'+ pullDirection +'"><div class="header"><strong class="primary-font sender">' + data[0]['sender'] + '</strong></div> <p class="chatmessage">' + data[0]['message'] + '</p></li><div class="clearfix"></div>'
                        '<p class="' + fromto + '>' + data[0]['message'] + '</p>'
                    );
                }
            // else if data == 'empty', i.e. no data at all for some reason...
            } else {
                $('.chat').html('<p style="color:#000; font-weight:500;">Your connection has been closed, if you want to start a new one please click the red button to start a new one.</p>' + `<a type="button"' class="btn btn-danger btn-xs close-connection" style="margin-right: 20px;">
                <span class="glyphicon glyphicon-remove"></span>
                </a>`);
            }

            //  var chat = document.getElementById('inner-chatroom');
            // chat.innerHTML = appendingData;
        },
        error: function(data) { }
    });
}

function close_sesion(chat_id){
    $.ajax({
        headers: {
            'X-CSRF-Token': $('input[name=_token]').val(),
        },
        url: '/messages/' + chat_id,
        type: 'DELETE',
        success: function(data) {
            sessionStorage.chat = 'closed';
        },
    });
}

function isWorkingHour(now) {
    return now.getDay() <= 5 && now.getHours() >= 15 && now.getHours() < 18;
}

function isAnyoneOnline() {
    $.ajax({
        headers: {
            'X-CSRF-Token': $('input[name=_token]').val(),
        },
        url: '/chatroom/online/',
        type: 'get',
        success: function (data) {
            console.log(data);
            console.log(data.outofservice);
            if (data.outofservice == true) {
                $('.out-of-service').css('display','block');
                $('#chat-customer-msg').attr('disabled',true);
                $('#chat-customer-send-msg').addClass('disabled');
            } else if (data.error) {
                $('.error-panel').append(data.error);
                $('#chat-customer-msg').attr('disabled',true);
                $('#chat-customer-send-msg').addClass('disabled');
                $('.error-panel').css('display','block');
            } else {
                $('.error-panel').css('display','none');
            }
        },
        error: function (data) {
        }
    });
}
