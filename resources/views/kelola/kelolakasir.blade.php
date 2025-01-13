<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h2
        class="flex items-center p-4 mb-6 space-x-3 text-3xl font-bold text-gray-800 rounded-lg shadow-md bg-gradient-to-r from-slate-200 to-slate-400">
        <i class="text-4xl text-slate-600 fas fa-user"></i> <!-- Ikon kasir -->
        <span class="flex flex-col">
            <span>Kelola Kasir</span>
            <span class="mt-1 text-lg font-normal text-gray-700">Manajemen dan Pengelolaan Kasir</span>
        </span>
    </h2>

    <div class="flex items-center justify-between mb-4">
        <!-- Form Pencarian -->
        <form action="{{ route('kelolakasir.index') }}" method="GET" class="flex items-center flex-grow">
            <input type="text" name="search" placeholder="Cari kasir..." value="{{ request()->get('search') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:outline-none w-80">
            <button type="submit"
                class="px-4 py-2 ml-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Cari</button>
            <a href="{{ route('kelolakasir.index') }}"
                class="px-4 py-2 ml-2 text-white bg-red-500 rounded-lg hover:bg-red-600">Reset</a>
        </form>

        @include('kelola.crudkasir.modal-create')
        @include('kelola.crudkasir.modal-edit')
        @include('kelola.crudkasir.modal-delete')

        <!-- Modal toggle -->
        @if (Auth::User()->role->nama_role === 'Admin')
            <button data-modal-target="tambah-kasir-modal" data-modal-toggle="tambah-kasir-modal"
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
                    <th class="px-3 py-3 border border-slate-300">Nama Kasir</th>
                    <th class="px-3 py-3 border border-slate-300">Username</th>
                    <th class="px-3 py-3 border border-slate-300">Nama Toko</th>
                    <th class="px-3 py-3 border border-slate-300">Role</th>
                    @if (Auth::User()->role->nama_role === 'Admin')
                        <th class="px-3 py-3 border border-slate-300">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                @forelse ($kasirs as $kasir)
                    <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $loop->iteration + $kasirs->firstItem() - 1 }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $kasir->name }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $kasir->username }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $kasir->nama_toko }}</td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $kasir->role->nama_role }}
                        </td>
                        @if (Auth::User()->role->nama_role === 'Admin')
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                                <div class="flex justify-center space-x-2">
                                    <button data-modal-target="edit-kasir-modal{{ $kasir->id }}"
                                        data-modal-toggle="edit-kasir-modal{{ $kasir->id }}"
                                        class="inline-flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-blue-500 rounded-lg shadow-md hover:bg-blue-600"
                                        type="button">
                                        <i class="mr-2 fas fa-edit"></i>
                                        Edit
                                    </button>
                                    <button data-modal-target="hapus-kasir-modal{{ $kasir->id }}"
                                        data-modal-toggle="hapus-kasir-modal{{ $kasir->id }}"
                                        class="flex items-center px-4 py-2 text-white transition duration-300 ease-in-out transform bg-red-500 rounded-lg shadow-md hover:bg-red-600">
                                        <i class="mr-2 fas fa-trash-alt"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                            Data Kasir belum Tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $kasirs->links() }}
    </div>
</x-layout>
