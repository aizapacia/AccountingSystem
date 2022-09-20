<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/template/images/favicon.png') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <!-- plugins -->
    <link rel="stylesheet" href="{{url('/template/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{url('/template/plugins/themify-icons/themify-icons.css') }}">


    <!-- Main Stylesheet -->
    <link href="{{url('/template/css/style.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div id="app">

        <header class="sticky-top navigation">
            <div class=container>
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
                    <a class=navbar-brand href="{{ route('home') }}">
                        <img class=" img-fluid" src="{{ url('/template/images/logo.png') }}" alt="Accounting">
                    </a>

                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item" style="list-style: none;">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif
                    @else
                    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation">
                        <i class="ti-align-right h4 text-dark"></i></button>
                    <div class="collapse navbar-collapse text-center" id=navigation>
                        <ul class="navbar-nav mx-auto align-items-center">
                            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('report') }}">Report</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('distributor') }}">Distributor</a></li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>

                    @endguest
                </nav>
            </div>
        </header>


        <main class="py-4">
            @yield('content')
        </main>

        <!--     <footer>
            <div class="container">
                <hr>
                <div class="py-4 text-center">

                    <small class="text-light"><a href="https://www.glogc.com/">Golog Malaysia, all rights reserved. 2022 ©</a></small>
                </div>
            </div>
        </footer> -->


        @yield('scripts')

        @livewireScripts
        <!-- plugins -->
        <script src="{{ url('/template/plugins/jQuery/jquery.min.js') }}"></script>
        <script src="{{ url('/template/plugins/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ url('/template/plugins/masonry/masonry.min.js') }}"></script>
        <script src="{{ url('/template/plugins/clipboard/clipboard.min.js') }}"></script>
        <script src="{{ url('/template/plugins/match-height/jquery.matchHeight-min.js') }}"></script>

        <!-- Main Script -->
        <script src="{{ url('/template/js/script.js') }}"></script>

        <!--ICon-->
        <script src="https://kit.fontawesome.com/3d127ccd55.js" crossorigin="anonymous"></script>
    </div>
</body>

</html>