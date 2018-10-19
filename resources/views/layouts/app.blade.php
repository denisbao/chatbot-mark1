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
    @include('layouts.default.menu_master')
    </header>

    <main>
        <section id="app">
            @yield('content')
        </section>
    </main>

    <footer class="footer">
      @include('layouts.default.footer')
    </footer>

    <script src="{{ mix('js/bootstrap.js') }}"></script>

</body>
</html>
