<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name').' - '.config('app.description')}}</title>

    @livewireStyles
    {{-- @powerGridStyles --}}
    <link rel="stylesheet" media="all" href="{!! mix('css/main.css') !!}" />
</head>

<body class="@yield('css_class')">
    @include('partials.nav-header')

    @yield('content')

    <script src="{!! mix('js/manifest.js') !!}"></script>
    <script src="{!! mix('js/vendor.js') !!}"></script>
    <script src="{!! mix('js/main.js') !!}"></script>
    @livewireScripts
    {{-- @powerGridScripts --}}
</body>

</html>
