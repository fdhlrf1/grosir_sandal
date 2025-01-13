<style>
    .sidebar::-webkit-scrollbar {
        display: none;
    }
</style>
<div class="bg-gray-500">
    <div class="flex flex-col min-h-screen sm:flex-row sm:justify-around">
        <div class="fixed top-0 left-0 w-64 h-screen overflow-y-auto bg-white border-r border-gray-200 sidebar">
            <div class="flex items-center justify-center mt-2 border-b border-l border-gray-200 py-14px">
                <img src="{{ asset('logo/New-Spon.png') }}" alt="New Spon App Logo" class="h-12">
            </div>

            <nav class="mt-4">
                <!-- Dashboard Link -->
                <x-side-link href="/beranda" :active="request()->is('beranda')">
                    <div class="flex items-center justify-center h-8 transition-colors">
                        <i class="mr-14px fas fa-tachometer-alt"></i>
                        <span class="font-medium">Beranda</span>
                    </div>
                </x-side-link>

                <!-- Data Utama with Sub Links -->
                <x-side-parent-link href="#" id="toggle-data" :active="request()->is('databarang') ||
                    request()->is('datapemasok') ||
                    request()->is('datakonsumen') ||
                    request()->is('datasatuan') ||
                    request()->is('datakategori') ||
                    request()->is('datawarna') ||
                    request()->is('datamotif') ||
                    request()->is('dataukuran') ||
                    request()->is('barang/create') ||
                    request()->is('barang/*/edit') ||
                    request()->is('pemasok/create') ||
                    request()->is('pemasok/*/edit') ||
                    request()->is('konsumen/create') ||
                    request()->is('konsumen/*/edit') ||
                    request()->is('satuan/create') ||
                    request()->is('satuan/*/edit') ||
                    request()->is('kategori/create') ||
                    request()->is('kategori/*/edit') ||
                    request()->is('motif/create') ||
                    request()->is('motif/*/edit') ||
                    request()->is('ukuran/create') ||
                    request()->is('ukuran/*/edit')">
                    <div class="flex items-center justify-center h-8 transition-colors">
                        <i class="mr-4 fas fa-database"></i>
                        <span class="font-medium">Data Utama</span>
                    </div>
                    <svg id="icon-data"
                        class="w-4 h-4 transition-transform transform {{ request()->is('databarang') || request()->is('datapemasok') || request()->is('datakonsumen') || request()->is('datasatuan') || request()->is('datakategori') || request()->is('datawarna') || request()->is('datamotif') || request()->is('dataukuran') || request()->is('barang/create') || request()->is('barang/*/edit') || request()->is('pemasok/create') || request()->is('pemasok/*/edit') || request()->is('konsumen/create') || request()->is('konsumen/*/edit') || request()->is('satuan/create') || request()->is('satuan/*/edit') || request()->is('kategori/create') || request()->is('kategori/*/edit') || request()->is('motif/create') || request()->is('motif/*/edit') || request()->is('ukuran/create') || request()->is('ukuran/*/edit') ? 'rotate-90' : 'rotate-0' }}"
                        viewBox="0 0 24 24" fill="none">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </x-side-parent-link>
                <div id="sub-links-data"
                    class="pl-0 {{ request()->is('databarang') || request()->is('datapemasok') || request()->is('datakonsumen') || request()->is('datasatuan') || request()->is('datakategori') || request()->is('datawarna') || request()->is('datamotif') || request()->is('dataukuran') || request()->is('barang/create') || request()->is('barang/*/edit') || request()->is('pemasok/create') || request()->is('pemasok/*/edit') || request()->is('konsumen/create') || request()->is('konsumen/*/edit') || request()->is('satuan/create') || request()->is('satuan/*/edit') || request()->is('kategori/create') || request()->is('kategori/*/edit') || request()->is('motif/create') || request()->is('motif/*/edit') || request()->is('ukuran/create') || request()->is('ukuran/*/edit') ? '' : 'hidden' }}">
                    <a href="/databarang"
                        class="flex items-center w-full px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Data
                        Barang</a>
                    <a href="/datapemasok"
                        class="flex items-center w-full px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Data
                        Pemasok</a>
                    <a href="/datakonsumen"
                        class="flex items-center w-full px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Data
                        Konsumen</a>
                    <a href="/datasatuan"
                        class="flex items-center w-full px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Data
                        Satuan</a>
                    <a href="/datakategori"
                        class="flex items-center w-full px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Data
                        Kategori</a>
                    <a href="/datamotif"
                        class="flex items-center w-full px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Data
                        Motif</a>
                    <a href="/dataukuran"
                        class="flex items-center w-full px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Data
                        Ukuran</a>
                </div>

                <x-side-parent-link href="#"
                    style="{{ Auth::User()->role->nama_role === 'Admin' ? '' : 'display:none' }}" id="toggle-kelola"
                    :active="request()->is('kelolakasir')">
                    <div class="flex items-center justify-center h-8 transition-colors">
                        {{-- <i class="mr-10px fas fa-cog"></i> --}}
                        <i class="mr-15px fas fa-cog"></i>
                        <span class="font-medium">Kelola</span>
                    </div>
                    <svg id="icon-kelola"
                        class="w-4 h-4 transition-transform transform rotate-0 {{ request()->is('kelolakasir') ? 'rotate-90' : 'rotate-0' }}"
                        viewBox="0 0 24 24" fill="none">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </x-side-parent-link>
                <div id="sub-links-kel" class="pl-0 {{ request()->is('kelolakasir') ? '' : 'hidden' }}">
                    <a href="/kelolakasir"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Kelola
                        Kasir</a>
                </div>

                {{-- @if (Auth::User()->role_id === 1) --}}
                <!-- Pencatatan with Sub Links -->
                <x-side-parent-link href="#"
                    style="{{ Auth::User()->role->nama_role === 'Admin' ? '' : 'display:none' }}" id="toggle-pencatatan"
                    :active="request()->is('pembelian')">
                    <div class="flex items-center justify-center h-8 transition-colors">
                        <i class="mr-18px fas fa-file-alt"></i>
                        <span class="font-medium">Pencatatan</span>
                    </div>
                    <svg id="icon-pencatatan"
                        class="w-4 h-4 transition-transform transform rotate-0 {{ request()->is('pembelian') ? 'rotate-90' : 'rotate-0' }}"
                        viewBox="0 0 24 24" fill="none">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </x-side-parent-link>
                <div id="sub-links-pct" class="pl-0 {{ request()->is('pembelian') ? '' : 'hidden' }}">
                    <a href="/pembelian"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Pembelian</a>
                </div>
                {{-- @endif --}}


                <!-- Transaksi with Sub Links -->
                <x-side-parent-link href="#" id="toggle-transaksi" :active="request()->is('penjualan')">
                    <div class="flex items-center justify-center h-8 transition-colors">
                        <i class="mr-18px fas fa-receipt"></i>
                        <span class="font-medium">Transaksi</span>
                    </div>
                    <svg id="icon-transaksi"
                        class="w-4 h-4 transition-transform transform rotate-0 {{ request()->is('penjualan') ? 'rotate-90' : 'rotate-0' }}"
                        viewBox="0 0 24 24" fill="none">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </x-side-parent-link>
                <div id="sub-links-trs" class="pl-0 {{ request()->is('penjualan') ? '' : 'hidden' }}">
                    {{-- <a href="/pembelian"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Pembelian</a> --}}
                    <a href="/penjualan"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Penjualan</a>
                    {{-- <a href="/pelunasan"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Pelunasan</a> --}}
                </div>

                <!-- Laporan with Sub Links -->
                <x-side-parent-link href="#" id="toggle-laporan" :active="request()->routeIs('pembelian.detail') ||
                    request()->routeIs('penjualan.detail') ||
                    request()->is('lapharian') ||
                    request()->is('lappenjualan') ||
                    request()->is('lappembelian') ||
                    request()->is('lappersediaan')">
                    <div class="flex items-center justify-center h-8 transition-colors">
                        <i class="mr-4 fas fa-chart-bar"></i>
                        <span class="font-medium">Laporan</span>
                    </div>
                    <svg id="icon-laporan"
                        class="w-4 h-4 transition-transform transform rotate-0 {{ request()->is('lapharian') || request()->is('lappenjualan') || request()->is('lappembelian') || request()->is('lappersediaan') || request()->routeIs('penjualan.detail') || request()->routeIs('pembelian.detail') ? 'rotate-90' : 'rotate-0' }}"
                        viewBox="0 0 24 24" fill="none">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </x-side-parent-link>
                <div id="sub-links-lpr"
                    class="pl-0 {{ request()->is('lapharian') || request()->is('lappenjualan') || request()->is('lappembelian') || request()->is('lappersediaan') || request()->routeIs('penjualan.detail') || request()->routeIs('pembelian.detail') ? '' : 'hidden' }}">
                    {{-- <a href="/lapharian"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">
                        <i class="mr-2 fas fa-file-alt"></i>
                        <span>Laporan Harian</span>
                    </a> --}}
                    <a href="/lappenjualan"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Laporan
                        Penjualan</a>
                    <a href="/lappembelian"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Laporan
                        Pembelian </a>
                    <a href="/lappersediaan"
                        class="flex items-center px-12 py-2 text-sm font-normal text-gray-600 rounded-lg hover:bg-blue-500 hover:text-white">Laporan
                        Persediaan</a>
                </div>



                <!-- Logout -->
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center px-6 py-3 mt-10 text-gray-600 hover:bg-gray-200 hover:text-gray-700">
                    <span class="flex items-center">
                        <i class="mr-4 fas fa-sign-out-alt"></i>
                        <span class="font-medium">Keluar</span>
                    </span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </nav>
        </div>
        <div class="flex-1 ml-64">
            <!-- Content here -->
        </div>
    </div>
</div>
