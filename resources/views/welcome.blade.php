<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token()
        ]) !!}
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body class="blue-grey lighten-5">
    {{--<header>--}}
        {{--NAV ALTERNATIVO--}}
        {{--<nav class="navbar">--}}
            {{--<div class="wrapper">--}}

                {{--<a data-target="slide-out" class="menu-btn sidenav-trigger show-on-large">--}}
                    {{--<i class="material-icons">menu</i>--}}
                {{--</a>--}}
                {{--<div class="container">--}}
                    {{--<a class="brand-logo center">--}}
                        {{--ChabotMark1--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</nav>--}}

        {{--NAV CURSO--}}
        <nav id="main-nav">
            <div class="nav-wrapper container-fluid grey darken-4">
                <div class="row">
                    <div class="col s12">
                        <a href="#/" class="brand-logo center"><i class="material-icons">chat</i>Chatbot</a>
                        <ul class="left">
                            <li>
                                <a data-target="slide-out" class="menu-btn sidenav-trigger show-on-large">
                                    <i class="material-icons">menu</i>
                                </a>

                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </nav>


        {{-- INICIO MENU--}}
        {{--<ul id="slide-out" class="sidenav">--}}
            {{--<li>--}}
                {{--<div class="user-view">--}}
                    {{--<div class="background"></div>--}}
                    {{--<div class="row valign-wrapper user-menu-header">--}}
                        {{--<div class="col col s4 m4 l4">--}}
                            {{--<img src="https://s3.sa-east-1.amazonaws.com/contador-online/development/users/account/1539494704.jpeg" alt="avatar" class="avatar">--}}
                        {{--</div>--}}
                        {{--<div class="col col s8 m8 l8">--}}
                            {{--<a class="dropdown-profile waves-effect waves-light white-text"--}}
                               {{--data-target="profile-dropdown-nav">--}}
                                {{--Nome--}}
                                {{--<i class="material-icons" style="font-size: 20px;">--}}
                                    {{--arrow_drop_down</i>--}}
                            {{--</a>--}}
                            {{--<ul id="profile-dropdown-nav" class="dropdown-content">--}}
                                {{--<li><a href="#">--}}
                                    {{--<i class="material-icons">account_circle</i>Meu Perfil</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}
        {{--</ul>--}}



    {{--</header>--}}

    {{--<main>--}}
        {{--<section id="app">--}}
            {{--<div class="container">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-content">--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</section>--}}
    {{--</main>--}}

    {{-- MENU CURSO --}}
    <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view">
                <div class="background"><img src="{{ asset('img/leaf_background.jpg') }}" alt=""></div>
                <a>
                    <img src="https://s.gravatar.com/avatar/06084bf7d041305f6cb68833c5757752?s=80" alt="" class="circle">
                </a>
                <a><span class="white-text name">Denis Bao Motta</span></a>
                <a href="https://gitbub.com/denisbao"><span class="white-text email">denis.tpd@gmail.com</span></a>
            </div>
        </li>

        <li><a href="" class="subheader">Bot Manager</a></li>
        <li><a href="#/" class="waves-effect">Postbacks</a></li>
        <li><a href="#/menus" class="waves-effect">Menus</a></li>

        <li><a href="" class="subheader">Conteúdos</a></li>
        <li><a href="#/products" class="waves-effect">Produtos</a></li>
        <li><a href="#/suggestions" class="waves-effect">Sugestões</a></li>

    </ul>
    {{--FIM MENU--}}



    <div id="app">

        {{--PRELOADER--}}
        <div class="preloader-container">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        {{--PRELOADER END--}}

    </div>

    {{--<footer class="footer">--}}
        {{--<div class="copyright">--}}
            {{--<div class="container">--}}
                {{--&copy {{ date('Y') }} Copyright | {{ config('app.name', 'Laravel') }}--}}
                {{--<span class="hide-on-small-only">--}}
                    {{--| All rights reserved.--}}
                {{--</span>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</footer>--}}

    <script src="{{ mix('js/bootstrap.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
