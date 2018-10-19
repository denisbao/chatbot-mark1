<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="wrapper">

                <a data-target="slide-out" class="menu-btn sidenav-trigger show-on-large">
                    <i class="material-icons">menu</i>
                </a>
                <div class="container">
                    <a class="brand-logo center">
                        ChabotMark1
                    </a>
                </div>
            </div>
        </nav>

    <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view">
                <div class="background"></div>
                <div class="row valign-wrapper user-menu-header">
                    <div class="col col s4 m4 l4">
                        <img src="https://s3.sa-east-1.amazonaws.com/contador-online/development/users/account/1539494704.jpeg" alt="avatar" class="avatar">
                    </div>
                    <div class="col col s8 m8 l8">
                        <a class="dropdown-profile waves-effect waves-light white-text"
                           data-target="profile-dropdown-nav">
                            Nome
                            <i class="material-icons" style="font-size: 20px;">
                                arrow_drop_down</i>
                        </a>
                        <ul id="profile-dropdown-nav" class="dropdown-content">
                            <li><a href="#">
                                    <i class="material-icons">account_circle</i>Meu Perfil</a>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </li>

        <li class="">
            <a href="#" class="waves-effect waves-blue">
                <i class="material-icons">business</i>
                Empresas
            </a>
        </li>


        <li class="">
            <a href="#" class="waves-effect waves-orange">
                <i class="material-icons">question_answer</i>
                Chamados
            </a>
        </li>

    </ul>

</header>

<main>
    <section id="app">
        <div class="container">
            <div class="card">
                <div class="card-content">








                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="copyright">
        <div class="container">

            &copy {{ date('Y') }} Copyright | {{ config('app.name', 'Laravel') }}
            <span class="hide-on-small-only">
         | All rights reserved.
       </span>

        </div>
    </div>

</footer>

<script src="{{ mix('js/bootstrap.js') }}"></script>

</body>
</html>
