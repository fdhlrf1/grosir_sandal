@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen">

        <div class="hidden w-5/12 bg-center bg-cover lg:block bg-slate-800"
            style="background-image: url('{{ asset('curved-images/curved2.jpg') }}'); border-radius: 15px;">

        </div>

        <!-- Right Section: Login Form -->
        <div class="flex items-center justify-center w-full p-8 bg-white lg:w-9/12">
            <div class="w-full max-w-md">
                <h2 class="text-3xl font-bold text-center text-gray-700">Masuk ke Akun Anda</h2>
                <p class="mt-4 text-center text-gray-500">Login cepat dan nyaman. Anda dapat kembali mengelola semua
                    kebutuhan toko Anda.</p>

                {{-- <p class="mt-4 text-sm text-center text-gray-600">
                    atau
                    <a href="{{ route('register') }}" class="font-medium text-blue-500 hover:text-blue-500 hover:underline">
                        Buat akun baru
                    </a>
                </p> --}}

                <!-- Login Form -->
                <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="-space-y-px rounded-md shadow-sm">
                        <div>
                            <label for="username" class="sr-only">Alamat Username</label>
                            <input id="username" name="username" type="username" autocomplete="username" required
                                class="mb-3 block w-full px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded appearance-none focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-300 ease-in-out @error('username') border-red-500 @enderror"
                                placeholder="Username" value="{{ old('username') }}" autofocus>
                            @error('username')
                                <span class="text-sm text-red-600 ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="mb-3 block w-full px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded appearance-none focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-300 ease-in-out @error('password') border-red-500 @enderror"
                                placeholder="Password">
                            @error('password')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if ($errors->has('login_error'))
                        <div class="mb-3 text-sm text-red-600">
                            {{ $errors->first('login_error') }}
                        </div>
                    @endif

                    {{-- <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="w-4 h-4 text-blue-500 border-gray-300 rounded focus:ring-blue-500">
                            <label for="remember_me" class="block ml-2 text-sm text-gray-900"> Ingat Saya </label>
                        </div>

                        <div class="text-sm">
                            <a href="#"
                                class="font-medium text-blue-500 transition hover:text-blue-500 hover:underline"> Lupa
                                Password? </a>
                        </div>
                    </div> --}}

                    <div>
                        <button type="submit"
                            class="relative flex justify-center w-full px-4 py-3 text-sm font-medium text-white transition border border-transparent rounded-md bg-slate-800 group hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Masuk
                        </button>
                    </div>
                </form>

                {{-- <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-medium text-blue-500 transition hover:text-blue-500 hover:underline">Daftar
                            disini</a>
                    </p>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
