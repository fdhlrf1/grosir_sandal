<!-- resources/views/datautama/d_barang.blade.php -->

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <h2
        class="flex items-center p-4 mb-6 space-x-3 text-3xl font-bold text-gray-800 rounded-lg shadow-md bg-gradient-to-r from-blue-200 to-blue-400">
        <i class="text-4xl text-blue-600 fas fa-boxes"></i>
        <span class="flex flex-col">
            <span>Data Barang</span>
            <span class="mt-1 text-lg font-normal text-gray-700">Manajemen dan Pengelolaan Barang
                Anda</span>
        </span>
    </h2>



    <div class="flex items-center justify-between mb-4">
        <!-- Form Pencarian -->
        <form action="{{ route('barang.index') }}" method="GET" class="flex items-center flex-grow">
            <input type="text" name="search" placeholder="Cari barang..." value="{{ request()->get('search') }}"
                class="px-4 py-2 font-normal border border-gray-300 rounded-lg focus:ring focus:outline-none w-80">
            <button type="submit"
                class="px-4 py-2 ml-2 font-normal text-white bg-blue-500 rounded-lg hover:bg-blue-600">Cari</button>
            <a href="{{ route('barang.index') }}"
                class="px-4 py-2 ml-2 font-normal text-white bg-red-500 rounded-lg hover:bg-red-600">Reset</a>
        </form>

        <!-- Tombol Tambah -->
        {{-- <a href="{{ route('barang.create') }}"
            class="inline-flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-green-500 rounded-lg shadow-md hover:bg-green-600 hover:scale-105">
            <i class="mr-2 fas fa-plus"></i> <!-- Menambahkan ikon tambah -->
            Tambah
        </a> --}}
    </div>
    {{-- @include('datautama.crudbarang.modal-edit') --}}



    <div class="overflow-x-auto">
        <table class="w-full overflow-hidden border-collapse rounded-lg shadow-lg table-auto">
            <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
                <tr>
                    <th class="px-3 py-3 border border-slate-300">No.</th>
                    <th class="px-6 py-3 border border-slate-300">Gambar</th>
                    <th class="px-3 py-3 border border-slate-300">Kategori Barang</th>
                    <th class="px-3 py-3 border border-slate-300">Size</th>
                    <th class="px-3 py-3 border border-slate-300">Motif</th>
                    <th class="px-3 py-3 border border-slate-300">Warna</th>
                    <th class="px-3 py-3 border border-slate-300">Pemasok</th>
                    <th class="px-3 py-3 border border-slate-300">Harga</th>
                    <th class="px-3 py-3 border border-slate-300">Stok</th>
                    @if (Auth::User()->role->nama_role === 'Admin')
                        <th class="px-3 py-3 border border-slate-300">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                @forelse ($barangs as $barang)
                    @php
                        //Ambil satuan dan konversi stok
                        $satuanNama = $barang->satuan->nama_satuan;
                        $stokAsli = $barang->stok;

                        if ($satuanNama === 'Kodi') {
                            $stokDitampilkan = $stokAsli / $barang->satuan->konversi;
                        } else {
                            $stokDitampilkan = $stokAsli;
                        }
                    @endphp
                    <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <td class="px-3 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            {{ $loop->iteration + $barangs->firstItem() - 1 }}</td>
                        <td class="px-3 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            @if ($barang->gambar)
                                <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="{{ $barang->nama }}"
                                    class="object-cover rounded-md shadow-md h-28 w-28">
                            @else
                                <span class="italic text-gray-500">No Image</span>
                            @endif
                        </td>
                        {{-- <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $barang->nama }}</td> --}}
                        <td class="px-2 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            {{ $barang->kategori->nama ?? 'N/A' }}</td>
                        <td class="px-2 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            {{ $barang->size }}</td>
                        <td class="px-2 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            {{ $barang->motif->nama_motif }}</td>
                        <td class="px-2 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            {{ $barang->warna }}</td>
                        <td class="px-2 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            {{ $barang->pemasok->nama ?? 'N/A' }}</td>
                        <td class="px-2 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            {{ number_format($barang->h_jual, 0, ',', '.') }}</td>
                        <td class="px-2 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            {{ $stokDitampilkan }}
                            {{ $satuanNama }}</td>
                        <td class="px-2 py-4 font-normal border border-slate-300 whitespace-nowrap">
                            <!-- Modal toggle -->
                            {{-- <button data-modal-target="edit-barang-modal{{ $barang->id }}"
                                data-modal-toggle="edit-barang-modal{{ $barang->id }}"
                                class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button">
                                Toggle modal
                            </button> --}}
                            @if (Auth::User()->role->nama_role === 'Admin')
                                <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');"
                                    action="{{ route('barang.destroy', $barang->id) }}" method="POST">
                                    <div class="flex flex-col space-y-2">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('barang.edit', $barang->id) }}"
                                            class="flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 hover:scale-105">
                                            <i class="mr-2 fas fa-edit"></i> Edit
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <!-- Tombol Hapus -->
                                        <button type="submit"
                                            class="flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-red-500 rounded-lg shadow-md hover:bg-red-600 hover:scale-105">
                                            <i class="mr-2 fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </div>
                                </form>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                            Data Barang belum Tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $barangs->appends(request()->input())->links() }}
    </div>
</x-layout>
