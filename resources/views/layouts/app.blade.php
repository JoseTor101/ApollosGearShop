<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
        rel="stylesheet" crossorigin="anonymous" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <!-- Vite CSS -->
    @vite('resources/css/app.css')

    <title>@yield('title', 'AGS')</title>
</head>

<body>
    <!-- header -->

    <nav class="navbar bg-dark navbar-expand-lg bg-body-secondary">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home.index') }}">
                <img src="{{ asset('images/logo_color.png') }}" alt="Apollo's Gear Shop Logo"
                    style="width: 40px; height: 40px; margin-right: 10px;">
                Apollo's Gear Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('instrument.index') }}">{{ __('navbar.list_instruments') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('lesson.index') }}">{{ __('navbar.list_lessons') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('order.index') }}">{{ __('navbar.list_orders') }}</a>
                    </li>
<!-- 
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('lesson.index') }}">{{ __('navbar.list_lessons') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('order.index') }}">{{ __('navbar.list_orders') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('stock.index') }}">{{ __('navbar.stock') }}</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('cart.index') }}">{{ __('navbar.cart') }}</a>
                    </li>

                </ul>
                <!-- Search Form -->
                <form class="d-flex" role="search" method="GET" action="{{ route('instrument.index') }}">
                    <input class="form-control me-2" type="search" name="searchByName" placeholder="{{ __('navbar.search_placeholder') }}" aria-label="Search" value="{{ request('searchByName') }}">
                    <button class="btn btn-outline-success" type="submit">{{ __('navbar.search_button') }}</button>
                </form>

                <div class="vr bg-white mx-2 d-none d-lg-block"></div>
                @guest
                    <a class="nav-link active px-2" href="{{ route('login') }}">Login</a>
                    <a class="nav-link active" href="{{ route('register') }}">Register</a>
                @else
                    <form id="logout" action="{{ route('logout') }}" method="POST">
                        <a role="button" class="nav-link active px-2" onclick="document.getElementById('logout').submit();">Logout</a>
                    @csrf
                    </form>
                @endguest


            </div>
        </div>
    </nav>

    <div class="masthead bg-primary text-white text-center py-4">
        <div class="container d-flex align-items-center flex-column">
            <h2>@yield('subtitle', __('navbar.subtitle'))</h2>

        </div>
    </div>

    <!-- content -->

    <div class="container my-4">
        @yield('content')
    </div>

    <!-- footer -->
    <div class="bg-secondary copyright py-4 text-center text-black">
        <div class="container">
            <small>
                {{ __('navbar.copyright') }} - <a class="text-reset fw-bold text-decoration-none" target="_blank"
                    href="#">
                    Apollo's Gear Shop Team
                </a>
            </small>
            <br>

            
            <div class="m-2 text-grey">
          
                <cite class="text-white font-weight-normal">
                    @isset($joke)
                        {{ $joke }}
                    @endisset
                </cite>
                <b>~JokeAPI</b>
            </div>

        </div>
    </div>
    <!-- footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous">
    </script>
</body>

</html>