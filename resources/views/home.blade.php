@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <div class="title">Laravel Live chat using firebase
                    <a href="#" id="logout" class="float-right">Logout</a>
                    <button id="delete-chat" class="float-right mr-2">Delete Chat</button>
                </div>
                <div class="users"></div>
            </div>
            <div class="card-body">

            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12">
                        <form id="chat-form">
                            <div class="input-group">
                                <input type="text" name="content" class="form-control"
                                       placeholder="Type your message ..."
                                       autocomplete="off">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group nik">
                            <input type="text" class="form-control" name="user_name"
                                   placeholder="What's your nickname?">

                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary" id="savename">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://www.gstatic.com/firebasejs/4.9.1/firebase.js"></script>
        <script>
            function clearChatsInFirebase() {
                firebase.database().ref('/chats').remove()
                    .then(function () {
                        // On success, clear the chat content in the UI
                        $(".card-body").html('<i>No chat</i>');
                    })
                    .catch(function (error) {
                        console.error('Error clearing chats in Firebase:', error);
                        // Handle error
                    });
            }

            // Inside the document ready function or anywhere appropriate
            $(document).ready(function () {
                // Call the clearChatsInFirebase function when the delete button is clicked
                $('#delete-chat').click(function () {
                    var ask = confirm('Are you sure you want to delete all chats?');
                    if (ask) {
                        clearChatsInFirebase();
                    }
                });
            });

            var old_users_val = $('.users').html();
            var scroll_bottom = function () {
                var card_height = 0;
                $('.card-body .chat-item').each(function () {
                    card_height += $(this).outerHeight();
                });
                $(".card-body").scrollTop(card_height);
            }
            var escapeHtml = function (unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            var config = {
                apikey: "{{ config('services.firebase.api_key') }}",
                authDomain: "{{ config('services.firebase.auth_domain') }}",
                databaseURL: "{{ config('services.firebase.database_url') }}",
                projectId: "{{ config('services.firebase.project_id') }}",
                storageBucket: "{{ config('services.firebase.storage_bucket') }}",
                messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}"
            };
            firebase.initializeApp(config);

            var users_name = [];
            firebase.database().ref('/chats').on('value', function (snapshot) {
                var chat_element = "";
                var data = snapshot.val(); // Get the value of the snapshot
                // console.log(data);
                if (data != null) {
                    // Check if data is an array
                    if (Array.isArray(data)) {
                        data.forEach(function (item, index) {
                            var chat_name = escapeHtml(item.name),
                                chat_content = escapeHtml(item.content);
                            chat_element += createChatElement(item, chat_name, chat_content);
                        });
                    } else {
                        // If not an array, assume it's an object and iterate over its keys
                        Object.keys(data).forEach(function (key) {
                            var item = data[key];
                            var chat_name = escapeHtml(item.name),
                                chat_content = escapeHtml(item.content);
                            chat_element += createChatElement(item, chat_name, chat_content);
                        });
                    }
                    $(".card-body").append(chat_element);
                } else {
                    $(".card-body").html('<i>No chat</i>');
                }
                scroll_bottom();
            }, function (error) {
                alert('ERROR! Please, open your console.');
                console.log(error);
            });

            function createChatElement(item, chat_name, chat_content) {
                var chat_element = '<div class="chat-item ' + item.type + '">';
                var chat_text_class = (item.type == 'chat' && chat_name === user_name) ? 'sent' : 'received';
                chat_element += '<div class="chat-container">';
                chat_element += '<div class="chat-text ' + chat_text_class + '">';
                if (item.type == 'chat') {
                    chat_element += '<div class="chat-name">';
                    chat_element += chat_name;
                    chat_element += '</div>';
                    chat_element += '<div class="chat-content">';
                    chat_element += chat_content;
                    chat_element += '</div>';
                } else if (item.type == 'info') {
                    chat_element += chat_name + ' has joined the chat';
                }
                chat_element += '</div>';
                chat_element += '</div>';
                chat_element += '</div>';
                chat_element += '<div class="chat-time ' + chat_text_class + '">' + formatTime(item.created_at) + '</div>';
                return chat_element;
            }

            function formatTime(timestamp) {
                var date = new Date(timestamp);
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // handle midnight
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var formattedTime = hours + ':' + minutes + ' ' + ampm;
                return formattedTime;
            }

            firebase.database().ref('/typing').on('value', function (snapshot) {
                var user = snapshot.val();
                if (user && user.name != user_name) {
                    $(".users").html(user.name + ' is typing...');
                } else {
                    $(".users").html(old_users_val);
                }
            });

            // Get user name from localStorage
            var user_name = localStorage.getItem('user_name');
            // If the user hasn't set their name
            // var myModal;
            if (!user_name) {
                // #savename action handler
                $("#savename").click(function () {
                    var input_user_name = $("[name=user_name]").val();

                    // Set user_name to localstorage
                    localStorage.setItem("user_name", input_user_name);

                    $.ajax({
                        url: '{{ route('chat.join') }}',
                        data: {
                            name: input_user_name
                        },
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr('content')
                        },
                        type: 'post',
                        beforeSend: function () {
                            $(".card").addClass('card-progress');
                        },
                        success: function () {
                            $(".card").removeClass('card-progress');
                            var user_name_btn = (input_user_name.length > 15 ? input_user_name.substring(0, 12) + '...' : input_user_name);
                            $("#chat-form button").html('Send');
                            $(".nik").hide();
                        }
                    });

                    // Close modal
                    // myModal.modal('hide');
                });
            }

            // #logout action handler
            $("#logout").click(function () {
                var ask = confirm('Are you sure?');
                if (ask) {
                    localStorage.removeItem("user_name");
                    location.reload();
                }
                return false;
            });

            // Set the card height equal to the height of the window
            $(".card-body").css({
                height: $(window).outerHeight() - 200,
                overflowY: 'auto'
            });

            // Set button text
            if (user_name) {
                var user_name_btn = (user_name.length > 15 ? user_name.substring(0, 12) + '...' : user_name);
                $("#chat-form button").html('Send');
                $(".nik").hide();
            }

            // #chat-form action handler
            $("#chat-form").submit(function () {
                // Get values
                var me = $(this),
                    chat_content = me.find('[name=content]'),
                    user_name = localStorage.getItem('user_name');

                // if the value of chat_content is empty
                if (chat_content.val().trim().length <= 0) {
                    // set focus to chat_content
                    chat_content.focus();
                } else if (!user_name) {
                    alert('oops...!!! We need your Name first!');
                } else {
                    // Send message to Firebase
                    var chatsRef = firebase.database().ref('/chats');

                    // Create a new chat object
                    var newChat = {
                        name: user_name,
                        content: chat_content.val().trim(),
                        type: 'chat', // or any other type you want to set
                        created_at: new Date().toISOString() // assuming you want to store the timestamp of the message
                    };
                    chatsRef.push(newChat)
                        .then(function () {
                            // On success, clear the chat content and focus on it
                            chat_content.val('');
                            chat_content.focus();
                            scroll_bottom(); // Scroll to bottom
                        })
                        .catch(function (error) {
                            console.error('Error sending message to Firebase:', error);
                            // Handle error
                        });
                }
                return false;
            });

            var timer;
            $("#chat-form [name=content]").keyup(function () {
                var ref = firebase.database().ref('typing');
                ref.set({
                    name: user_name
                });

                timer = setTimeout(function () {
                    ref.remove();
                }, 2000);
            });
        </script>

@endsection
