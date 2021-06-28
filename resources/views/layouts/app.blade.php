<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


<!--    <script src="{{ asset('js/app.js') }}"></script> -->

    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

<script>
    $(document).ready(function(){

        $("#bell").hide();



    function newBell(data){

    if(data.data == "yes"){

        $("#bell").show();
    }else{
        $("#bell").hide();
    }

    }
    setInterval(function(){
    $.ajax({
    url: "{{ url('search_newbell') }}",
    type: "get",
    dataType: "json",
    success: newBell
    });
    },5000)
    });


    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
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
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Вход') }}</a>
                            </li>

                        @else
                            @if( Auth::user()->role > 0 )
                            <a class="navbar-text" id="bell" href="{{ route('admin.other.index') }}" >    <i class="fa fa-bell" aria-hidden="true"  ></i> </a>
                            @endif

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        @switch(Auth::user()->role)
                                            @case(0)
                                            Агент
                                            @break
                                            @case(1)
                                            Менеджер
                                            @break
                                            @case(2)
                                            Администратор
                                            @break
                                            @case(3)
                                            SUPER Администратор
                                            @break
                                            @default
                                            UNKNOWN
                                        @endswitch<span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @if( Auth::user()->role > 1)
                                        <a class="dropdown-item" href="{{ route('admin.user_managment.users.index') }}">
                                            Операторы
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.bank.index') }}">
                                            Банк
                                        </a>
                                        @endif
                                        @if( Auth::user()->role > 0)
                                        <a class="dropdown-item" href="{{ route('admin.color1.index') }}">
                                            Базовый цвет
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.color2.index') }}">
                                            Вторичный цвет
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.comment1.index') }}">
                                            Комментарий
                                        </a>
                                        @endif
                                        @if( Auth::user()->role >= 0)
                                        <a class="dropdown-item" href="{{ route('client.index') }}">
                                            Клиент
                                        </a>
                                        @endif
                                        @if( Auth::user()->role > 1)
                                        <a class="dropdown-item" href="{{ route('admin.other.index') }}">
                                            Статистика
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.baseasg.index') }}">
                                            Реестр АСЖ
                                        </a>
                                            @endif
                                            @if( Auth::user()->role > 0)
                                        <a class="dropdown-item" href="{{ route('admin.template.index') }}">
                                            Шаблоны СМС
                                        </a>


                                            <a class="dropdown-item" href="<?php if(strncmp($_SERVER['REMOTE_ADDR'],'10.0',3)==0)
                                            {echo "http://10.8.0.1/phpMyAdmin/";
                                            }else{
                                                echo "http://192.168.88.99/phpMyAdmin/";
                                            }?>">
                                                Веб интерфейс базы
                                            </a>
                                            <a class="dropdown-item" href="<?php if(strncmp($_SERVER['REMOTE_ADDR'],'10.0',3)==0)
                                            {echo "http://10.8.0.1/cdrru/";
                                            }else{
                                                echo "http://192.168.88.99/cdrru/";
                                            }?>">
                                                Астериск база

                                            </a>

                                                <a class="dropdown-item" href="{{ route('findclient.index') }}">
                                                    Поиск клиента
                                                </a>

                                            @endif

                                    </div>
                                </li>



                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Выход') }}
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
</body>
</html>
