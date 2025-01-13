<!-- Di dalam layout.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- <link rel="icon" type="image/png" href="{{ asset('logo/NewSpon.png') }}"> --}}
    @vite('resources/css/app.css')
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    {{-- <link href="{{ asset('flowbite/flowbite.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> --}}

    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet"> --}}

    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet"> --}}


    <style>
        .swal2-confirm.blue-button {
            color: white;
            background-color: #3F83F8;
            border: none;

        }

        .swal2-confirm.blue-button:hover {
            transition: 1s;
            background-color: #1C64F2;

        }
    </style>

</head>

<body class="bg-gray-100">
    <main>
        <div class="flex min-h-screen">
            <x-sidebar></x-sidebar>
            <div class="flex-grow">
                <x-header>{{ $title }}</x-header>
                <div class="p-4">
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="p-5">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Flowbite --}}
</body>

{{-- <script src="{{ asset('flowbite/flowbite.min.js') }}"></script> --}}
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>

{{-- @include('sweetalert::alert') --}}
<script>
    //message with sweetalert
    @if (session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif (session('login_message'))
        Swal.fire({
            title: 'Selamat Datang {{ session('login_message')['name'] }}!',
            text: 'Hak Akses: {{ session('login_message')['role'] }}',
            confirmButtonText: 'OK'
        });
    @elseif (session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif (session('errorpelunasan'))
        Swal.fire({
            icon: "error",
            title: "Pelunasan Gagal!",
            text: "{{ session('errorpelunasan') }}",
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'blue-button' // Add the custom class here
            }
        });
    @elseif (session('errortanggal'))
        Swal.fire({
            icon: "error",
            title: "Filter Gagal!",
            text: "{{ session('errortanggal') }}",
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'blue-button' // Add the custom class here
            }
        });
    @elseif ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Data tidak valid!',
            text: 'Silakan periksa kembali input Anda.',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'blue-button' // Add the custom class here
            }
        });
    @elseif (session('toastberhasil'))
        Swal.fire({
            toast: true,
            icon: 'success',
            title: '{{ session('toastberhasil') }}',
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>

</html>
