<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Philippine Institute of Civil Engineers</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="shortcut icon" href="{{ asset('images/piceicon.png') }}" type="image/x-icon">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    body{
        height:"100%";
        background-image: url('{{ asset('images/login.jpg')  }}');
                          
    background-repeat:   no-repeat;
    background-position: center center;
    background-size: cover; 
    }

    .btn-primary {
        color: #fff;
        background-color: #262042;
        border-color: #262042;
    }

    </style>
</head>
<body>
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid" >
                <a class="navbar-brand" href="{{ url('/') }}" style="padding-top:20px;" >
                    <img src="{{ asset('images/pice_name.png') }}" class="img-fluid" height="90" width="400"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" style=" font-size:17px"  >
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Membership Registration') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="py-4 align-items-center">
            @yield('content')
        </main>
        <footer>
            <p class="text-center copyright" style="color:white">
                Copyright © 
                2018. Philippine Institute of Civil Engineers            <br>

            Powered by Arsokos<br><img src="{{ asset('images/arsokos_logo.png') }}" class="rounded-circle" height="100" width="110"/></p> 

        </footer>
    </div>
</body>
</html>
