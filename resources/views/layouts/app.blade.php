<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Babble') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>

        body {
            background-image: image()
            background-image:  repeating-linear-gradient(red, yellow 10%, green 20%);
        background-color: #000000;
        }


        ul{
            margin: 0;
            padding: 0;
        }

        li {
            list-style: none;

        }
        .user-wrapper, .message-wrapper {
            border: 2px solid #111111;
            overflow-y: auto;
        }
        .user-wrapper{
            height: 500px;
            background: #FFFFFF;
            }
        
        .user {
            cursor: pointer;
            padding: 5px 0;
            position: relative;
        }

        .user:hover{
            background: #D0CCCC;
        }

        .user:last-child{
            margin-bottom: 0;
        }

        .pending{
            position: absolute;
            left: 13px;
            top: 9px;
            background: #E74C3A;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }

        .media-left {
            margin: 0 10px;

        }    

        .media-left img {
            width: 64px;
            border-radius: 64px;
            object-fit: contain;

        }

        .media-body p {
            margin: 6px 0;
        }

        .message-wrapper{
            padding: 10px;
            height: 440px;
            background: #000000;
        }

        .messages .message{
            margin-bottom: 15px;
        }

        .messages .message:last-child{
            margin-bottom: 0;
        }
        .received, .sent{
            width: 45%;
            padding: 3px 10px;
            border-radius: 10px;
        }

        .received {
            background: #ADA7A6;
        }

        .sent{
            background: #3399ff;
            float: right;
            color:#fff;
            text-align: right;
        }   

        .sent > .date{
            color:#fff;
        }

        .message p {
            margin: 5px 0;
        }     

        .date {
           color: #2C3E50;
           font-size: 12px;
        }

        .active {
            background: #ADA7A6;
        }

        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 15px 0 0 0 ;
            display: inline-block;
            border-radius: 4px;
            box-sizing: border-box;
            outline:none;
            border: 1px solid #9B9797;
        
        }

        input[type=text]: focus {
            border: 10px solid #ffffff;
        }


    </style>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
             <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!--{ { config('app.name', 'Babble') }} -->
                    Babble
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="position:relative; padding-left:50px;"v-pre>
                                    <img src="/uploads/avatars/{{ Auth::user()->avatar}}"  style="width:32px; height:32px; position:absoulte; top:10px; left:10px; border-radius:50%">

                                    
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('settings') }}">
                                        {{ ('Settings') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ url('profile') }}">
                                        {{ ('Profile') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    var receiver_id = '';
    var my_id = "{{ Auth::id() }}";
    $(document).ready(function(){
        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('82fb561db49772b8967c', {
            cluster: 'ap2',
            forceTLS: false
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
           
            if (my_id == data.from) {
                $('#' + data.to).click();
            } else if (my_id == data.to) {
                if (receiver_id == data.from) {
                    // if receiver is selected, reload the selected user ...
                    $('#' + data.from).click();
                } else {
                    // if receiver is not seleted, add notification for that user
                    var pending = parseInt($('#' + data.from).find('.pending').html());
                    if (pending) {
                        $('#' + data.from).find('.pending').html(pending + 1);
                    } else {
                        $('#' + data.from).append('<span class="pending">1</span>');
                    }
                }
            }
        });

        $('.user').click(function () {
            $('.user').removeClass('active');
            $(this).addClass('active');
            receiver_id = $(this).attr('id');
            
            $(this).find('.pending').remove();
            $.ajax({
                type: "get",
                url: "message/" + receiver_id, // need to create this route
                data: "",
                success: function (data) {
                    $('#messages').html(data)
                    scrollToBottomFunc();
                }
            });
        });

        $(document).on('keyup', '.input-text input', function(e){
            var message = $(this).val();
            if(e.keyCode == 13 && message != '' && receiver_id != ''){
                $(this).val('');

                var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                $.ajax({
                    type: "post",
                    url: "message",
                    data: datastr,
                    cache: false,
                    success: function(data) {

                    },
                    error: function(jqXHR, status, err){
                        
                    },
                    complete: function(){
                        scrollToBottomFunc();
                    }
                });
            }
        });
    });
    // make a function to scroll down auto 
    function scrollToBottomFunc() {
        $('.message-wrapper').animate({
            scrollTop: $('.message-wrapper').get(0).scrollHeight
        }, 50);
    }
</script>
</body>
</html>
