<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>







    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Wallet') }}</title>
   @include('layouts.scripts')

</head>
<body>
    <div id="app">
        @include('layouts.menus.navbar')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>
</html>
