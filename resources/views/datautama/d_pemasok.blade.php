<!-- resources/views/datautama/d_pemasok.blade.php -->

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <h2
        class="flex items-center p-4 mb-6 space-x-3 text-3xl font-bold text-gray-800 rounded-lg shadow-md bg-gradient-to-r from-orange-200 to-orange-400">
        <i class="text-4xl text-orange-600 fas fa-truck"></i>
        <span class="flex flex-col">
            <span>Data Pemasok</span>
            <span class="mt-1 text-lg font-normal text-gray-700">Manajemen dan Pengelolaan Pemasok Anda</span>
        </span>
    </h2>

    <div class="flex items-center justify-between mb-4">
        <!-- Form Pencarian -->
        <form action="{{ route('pemasok.index') }}" method="GET" class="flex items-center flex-grow">
            <input type="text" name="search" placeholder="Cari pemasok..." value="{{ request()->get('search') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:outline-none w-80">
            <button type="submit" class="px-4 py-2 ml-2 text-white bg-blue-500 rounded-lg ">Cari</button>
            <a href="{{ route('pemasok.index') }}"
                class="px-4 py-2 ml-2 text-white bg-red-500 rounded-lg hover:bg-red-600">Reset</a>
        </form>

        @include('datautama.crudpemasok.modal-create')
        @include('datautama.crudpemasok.modal-edit')
        @include('datautama.crudpemasok.modal-delete')

        <!-- Modal toggle -->
        @if (Auth::User()->role->nama_role === 'Admin')
            <button data-modal-target="tambah-pemasok-modal" data-modal-toggle="tambah-pemasok-modal"
                class="inline-flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-green-500 rounded-lg shadow-md hover:bg-green-600"
                type="button">
                <i class="mr-2 fas fa-plus"></i>
                Tambah
            </button>
        @endif

    </div>

    <div class="overflow-x-auto">
        <table class="w-full overflow-hidden border-collapse rounded-lg shadow-lg table-auto">
            <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
                <tr>
                    <th class="px-3 py-3 font-sans border border-slate-300">No.</th>
                    <th class="px-3 py-3 font-sans border border-slate-300">Nama Pemasok</th>
                    <th class="px-3 py-3 font-sans border border-slate-300">Alamat</th>
                    <th class="px-3 py-3 font-sans border border-slate-300">Telepon</th>
                    @if (Auth::User()->role->nama_role === 'Admin')
                        <th class="px-3 py-3 font-sans border border-slate-300">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                @forelse ($pemasoks as $pemasok)
                    <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $loop->iteration + $pemasoks->firstItem() - 1 }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $pemasok->nama }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $pemasok->alamat }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $pemasok->telepon }}</td>
                        @if (Auth::User()->role->nama_role === 'Admin')
                            <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                                <div class="flex justify-center space-x-2">
                                    <button data-modal-target="edit-pemasok-modal{{ $pemasok->id_pemasok }}"
                                        data-modal-toggle="edit-pemasok-modal{{ $pemasok->id_pemasok }}"
                                        class="inline-flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-blue-500 rounded-lg shadow-md hover:bg-blue-600"
                                        type="button">
                                        <i class="mr-2 fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button data-modal-target="hapus-pemasok-modal{{ $pemasok->id_pemasok }}"
                                        data-modal-toggle="hapus-pemasok-modal{{ $pemasok->id_pemasok }}"
                                        class="flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-red-500 rounded-lg shadow-md hover:bg-red-600">
                                        <i class="mr-2 fas fa-trash-alt"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                            Data Pemasok belum Tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $pemasoks->links() }}
    </div>
</x-layout>
