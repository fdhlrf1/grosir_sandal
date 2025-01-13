<!-- resources/views/datautama/d_konsumen.blade.php -->

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <h2
        class="flex items-center p-4 mb-6 space-x-3 text-3xl font-bold text-gray-800 rounded-lg shadow-md bg-gradient-to-r from-red-200 to-red-400">
        <i class="text-4xl text-red-600 fas fa-users"></i> <!-- Ikon konsumen -->
        <span class="flex flex-col">
            <span>Data Konsumen</span>
            <span class="mt-1 text-lg font-normal text-gray-700">Manajemen dan Pengelolaan Konsumen</span>
        </span>
    </h2>

    <div class="flex items-center justify-between mb-4">
        <!-- Form Pencarian -->
        <form action="{{ route('konsumen.index') }}" method="GET" class="flex items-center flex-grow">
            <input type="text" name="search" placeholder="Cari konsumen..." value="{{ request()->get('search') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:outline-none w-80">
            <button type="submit"
                class="px-4 py-2 ml-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Cari</button>
            <a href="{{ route('konsumen.index') }}"
                class="px-4 py-2 ml-2 text-white bg-red-500 rounded-lg hover:bg-red-600">Reset</a>
        </form>

        @include('datautama.crudkonsumen.modal-create')
        @include('datautama.crudkonsumen.modal-edit')
        @include('datautama.crudkonsumen.modal-delete')

        <!-- Modal toggle -->
        @if (Auth::User()->role->nama_role === 'Admin')
            <button data-modal-target="tambah-konsumen-modal" data-modal-toggle="tambah-konsumen-modal"
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
                    <th class="px-3 py-3 border border-slate-300">No.</th>
                    <th class="px-3 py-3 border border-slate-300">Nama Konsumen</th>
                    <th class="px-3 py-3 border border-slate-300">Alamat</th>
                    <th class="px-3 py-3 border border-slate-300">Telepon</th>
                    @if (Auth::User()->role->nama_role === 'Admin')
                        <th class="px-3 py-3 border border-slate-300">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                @forelse ($konsumens as $konsumen)
                    <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $loop->iteration + $konsumens->firstItem() - 1 }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $konsumen->nama }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $konsumen->alamat }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $konsumen->telepon }}</td>
                        @if (Auth::User()->role->nama_role === 'Admin')
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                                <div class="flex justify-center space-x-2">
                                    <button data-modal-target="edit-konsumen-modal{{ $konsumen->id_konsumen }}"
                                        data-modal-toggle="edit-konsumen-modal{{ $konsumen->id_konsumen }}"
                                        class="inline-flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-blue-500 rounded-lg shadow-md hover:bg-blue-600"
                                        type="button">
                                        <i class="mr-2 fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button data-modal-target="hapus-konsumen-modal{{ $konsumen->id_konsumen }}"
                                        data-modal-toggle="hapus-konsumen-modal{{ $konsumen->id_konsumen }}"
                                        class="flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-red-500 rounded-lg shadow-md hover:bg-red-600">
                                        <i class="mr-2 fas fa-trash-alt"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                            Data Konsumen belum Tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $konsumens->links() }}
    </div>
</x-layout>
