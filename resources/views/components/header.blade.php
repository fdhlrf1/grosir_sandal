<!-- Header -->
<header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shadow-md">

    <div class="flex items-center space-x-4">
        <!-- Welcome and Admin Name -->
        <div class="flex flex-col items-start space-y-1">
            <!-- Welcome Message -->
            <span class="text-sm font-medium text-gray-500">Selamat Datang,</span>
            <!-- Admin Name -->
            <span class="text-lg font-semibold text-gray-700">{{ Auth::user()->name }}!</span>
        </div>
    </div>

    <!-- Search Bar with icon inside the input field -->
    {{-- <div class="relative flex items-center w-1/2">
        <!-- Search Icon -->
        <i class="absolute text-gray-400 fas fa-search left-3"></i>
        <!-- Search Input Field -->
        <input type="text" placeholder="     Cari disini..."
            class="w-full px-10 border border-gray-300 rounded-lg py-4px focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div> --}}

    <!-- Account Info -->
    <div class="flex items-center p-2 space-x-6">
        <!-- Keterangan Hak Akses -->
        <div class="flex items-center space-x-2">
            @if (Auth::User()->role->nama_role === 'Admin')
                <i class="text-3xl text-cyan-800 fas fa-user-cog"></i>
            @elseif (Auth::User()->role->nama_role === 'Kasir')
                <i class="text-3xl text-cyan-800 fas fa-user-circle"></i>
            @endif
            {{-- <i class="text-3xl text-cyan-800 fas fa-user-circle"></i> --}}
            <span class="text-lg font-semibold text-cyan-800">
                {{ Auth::User()->role->nama_role === 'Admin' ? 'Admin' : 'Kasir' }}
            </span>
        </div>

        <!-- Pemisah Garis Vertikal -->
        <div class="w-px h-8 bg-gray-300"></div>

        <!-- Keterangan Nama Toko -->
        <div class="flex items-center space-x-2">
            <i class="text-3xl text-cyan-800 fas fa-store"></i>
            <span class="text-lg font-semibold text-cyan-800">{{ Auth::User()->toko->nama_toko }}</span>
        </div>
    </div>

</header>

<!-- Judul Halaman -->
{{-- <div class="px-6 py-3">
    <h1 class="text-xl text-blue-800 font-regular">{{ $slot }}</h1>

</div> --}}

<nav class="flex pt-4 pb-0 pl-5 pr-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li aria-current="page" class="inline-flex items-center">
            <div
                class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400 dark:hover:text-white">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="mr-2"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 13H11V3H3V13ZM13 21H21V11H13V21ZM13 3V9H21V3H13ZM3 21H9V15H3V21Z" />
                </svg>
                {{ $slot }}
            </div>
        </li>
    </ol>
</nav>
