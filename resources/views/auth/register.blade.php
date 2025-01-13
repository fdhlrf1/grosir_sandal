@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen">
        <!-- Left Section: Image/Logo -->
        <div class="hidden w-5/12 bg-center bg-cover shadow-lg lg:block bg-slate-800"
            style="background-image: url('{{ asset('curved-images/curved6.jpg') }}'); border-radius: 15px;">
        </div>


        {{-- <img src="{{asset('curved-images/curved-10.jpg')}}" alt="" srcset=""> --}}

        <!-- Right Section: Registration Form -->
        <div class="flex items-center justify-center w-full p-8 bg-white lg:w-9/12">
            <div class="w-full max-w-md">
                <h2 class="text-3xl font-bold text-center text-gray-700">Daftar Akun Baru</h2>
                {{-- <p class="mt-4 text-sm text-center text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-blue-500 hover:text-blue-500 hover:underline">
                    Masuk disini
                </a>
            </p> --}}

                <!-- Registration Form -->
                <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="-space-y-px rounded-md shadow-sm">
                        <!-- Nama -->
                        <div>
                            <label for="name" class="sr-only">Nama</label>
                            <input id="name" name="name" type="text" required
                                class="mb-3 block w-full px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded appearance-none focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-300 ease-in-out @error('name') border-red-500 @enderror"
                                placeholder="Nama Lengkap" value="{{ old('name') }}" autofocus>
                            @error('name')
                                <span class="text-sm text-red-600 ">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- username -->
                        <div>
                            <label for="username" class="sr-only">Username</label>
                            <input id="username" name="username" type="username" required
                                class="mb-3 block w-full px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded appearance-none focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-300 ease-in-out @error('username') border-red-500 @enderror"
                                placeholder="Username" value="{{ old('username') }}">
                            @error('username')
                                <span class="text-sm text-red-600 ">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nama Toko -->
                        <div>
                            <label for="nama_toko" class="sr-only">Nama Toko</label>
                            <input id="nama_toko" name="nama_toko" type="text" required
                                class="mb-3 block w-full px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded appearance-none focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-300 ease-in-out @error('nama_toko') border-red-500 @enderror"
                                placeholder="Nama Toko" value="{{ old('nama_toko') }}">
                            @error('nama_toko')
                                <span class="text-sm text-red-600 ">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" required
                                class="mb-3 block w-full px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded appearance-none focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-300 ease-in-out @error('password') border-red-500 @enderror"
                                placeholder="Password">
                            @error('password')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="sr-only">Confirm Password</label>
                            <input id="password-confirm" type="password"
                                class="block w-full px-4 py-2 mb-3 text-gray-700 transition duration-300 ease-in-out bg-gray-100 border border-gray-300 rounded appearance-none focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                                name="password_confirmation" required placeholder="Konfirmasi Password">
                        </div>

                    </div>

                    <div>
                        <button type="submit"
                            class="relative flex justify-center w-full px-4 py-3 text-sm font-medium text-white transition border border-transparent rounded-md bg-slate-800 group hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="font-medium text-blue-500 hover:text-blue-500 hover:underline">Masuk disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
