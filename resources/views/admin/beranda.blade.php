<x-layout>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container mx-auto">
        <!-- Selamat Datang -->
        {{-- <div class="p-4 mb-6 bg-blue-100 border border-blue-300 rounded-lg">
            <h1 class="text-2xl font-bold text-blue-800">Selamat Datang di Aplikasi Grosir Sandal!</h1>
            <p class="text-gray-700">Aplikasi ini membantu Anda mengelola stok barang, mencatat pembelian dan penjualan,
                serta menyediakan laporan lengkap untuk toko grosir sandal Anda.</p>
        </div> --}}

        <!-- Navigasi Cepat ke Halaman Utama -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <!-- Total Sales -->
            <div class="p-4 bg-gray-100 border border-gray-100 rounded-lg shadow">
                <div class="flex items-center">
                    <i class="text-3xl text-purple-500 fas fa-tags"></i>
                    <div class="ml-3">
                        <h2 class="text-xl font-semibold text-gray-800">Total Sales</h2>
                        <p class="text-2xl font-bold text-gray-900">$12,345</p>
                        <p class="text-sm text-blue-500">↑ 20% Than Last Month</p>
                    </div>
                </div>
            </div>

            <!-- Total Expense -->
            <div class="p-4 bg-gray-100 border border-gray-100 rounded-lg shadow">
                <div class="flex items-center">
                    <i class="text-3xl text-blue-500 fas fa-file-invoice-dollar"></i>
                    <div class="ml-3">
                        <h2 class="text-xl font-semibold text-gray-800">Total Expense</h2>
                        <p class="text-2xl font-bold text-gray-900">$3,213</p>
                        <p class="text-sm text-blue-500">↑ 8% Than Last Month</p>
                    </div>
                </div>
            </div>

            <!-- Payment Sent -->
            <div class="p-4 bg-gray-100 border border-gray-100 rounded-lg shadow">
                <div class="flex items-center">
                    <i class="text-3xl fas fa-paper-plane text-cyan-500"></i>
                    <div class="ml-3">
                        <h2 class="text-xl font-semibold text-gray-800">Payment Sent</h2>
                        <p class="text-2xl font-bold text-gray-900">$65,920</p>
                        <p class="text-sm text-blue-500">↑ 32% Than Last Month</p>
                    </div>
                </div>
            </div>

            <!-- Payment Received -->
            <div class="p-4 bg-gray-100 border border-gray-100 rounded-lg shadow">
                <div class="flex items-center">
                    <i class="text-3xl text-green-500 fas fa-hand-holding-usd"></i>
                    <div class="ml-3">
                        <h2 class="text-xl font-semibold text-gray-800">Payment Received</h2>
                        <p class="text-2xl font-bold text-gray-900">$72,840</p>
                        <p class="text-sm text-red-500">↓ 3% Than Last Month</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 gap-4 mb-6">
            <!-- Notifikasi & Pemberitahuan Penting -->
            <div class="p-4 mb-6 bg-yellow-100 border border-yellow-300 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-yellow-800">Notifikasi & Pemberitahuan Penting</h2>
                <p class="mt-2 text-gray-700">Anda memiliki beberapa item dengan stok rendah. Segera lakukan pembelian
                    untuk
                    menghindari kekurangan stok.</p>
            </div>

            <!-- Statistik Penjualan dan Pembelian Terbaru -->
            <div class="p-4 mb-6 bg-white border border-gray-200 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-gray-800">Statistik Penjualan dan Pembelian Terbaru</h2>
                <p class="mt-2 text-gray-600">Lihat ringkasan penjualan dan pembelian terbaru untuk minggu ini, termasuk
                    item paling laris dan pemasok aktif.</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <!-- Notifikasi & Pemberitahuan Penting -->
            <div class="p-4 mb-6 bg-yellow-100 border border-yellow-300 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-yellow-800">Notifikasi & Pemberitahuan Penting</h2>
                <p class="mt-2 text-gray-700">Anda memiliki beberapa item dengan stok rendah. Segera lakukan pembelian
                    untuk
                    menghindari kekurangan stok.</p>
            </div>

            <!-- Statistik Penjualan dan Pembelian Terbaru -->
            <div class="p-4 mb-6 bg-white border border-gray-200 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-gray-800">Statistik Penjualan dan Pembelian Terbaru</h2>
                <p class="mt-2 text-gray-600">Lihat ringkasan penjualan dan pembelian terbaru untuk minggu ini, termasuk
                    item paling laris dan pemasok aktif.</p>
            </div>
        </div>


        {{-- <div class="container p-6 mx-auto">
            <div class="p-4 mb-6 bg-white border border-gray-200 rounded-lg shadow">
                <h2 class="mb-4 text-2xl font-semibold text-gray-800">Statistik Data Penjualan Hari Ini</h2>

                <!-- Jumlah Transaksi -->
                <div class="flex items-center justify-between mb-3">
                    <span class="font-medium text-gray-700">Total Transaksi</span>
                    <span class="text-lg font-bold text-blue-600">200 transaksi</span>
                </div>

                <!-- Total Pendapatan Hari Ini -->
                <div class="flex items-center justify-between mb-3">
                    <span class="font-medium text-gray-700">Total Pendapatan</span>
                    <span class="text-lg font-bold text-green-600">Rp
                        2000</span>
                </div>

                <!-- Produk Terlaris Hari Ini -->
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">Produk Terlaris</span>
                    <span class="text-lg font-bold text-red-600">SANDAL</span>
                </div>
            </div>
        </div> --}}

    </div>


</x-layout>
