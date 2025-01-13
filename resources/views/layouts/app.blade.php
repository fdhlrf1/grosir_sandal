<!DOCTYPE html>
<html>

<head>
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    {{-- <link rel="icon" type="image/png" href="{{ asset('logo/NewSpon.png') }}"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body>
    <div id="app">


        <main class="py-0">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
