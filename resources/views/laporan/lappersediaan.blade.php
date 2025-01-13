<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container px-6 py-4 mx-auto">
        <h1 class="pb-3 mb-6 text-3xl font-bold text-center text-gray-800 border-b-4 border-blue-500">
            <span class="text-blue-600">Laporan Persediaan</span>
        </h1>

        <div class="flex items-center justify-between p-4 mb-6 border border-blue-200 rounded-lg shadow-sm bg-blue-50">
            <p class="text-sm font-medium text-gray-700">
                Ini adalah Laporan Keseluruhan Stok Barang Anda Berdasarkan Kategori Barang
            </p>
            @if (Auth::User()->role->nama_role === 'Admin')
                <div class="flex ml-auto space-x-4">
                    <a href="{{ route('laporanpersediaan.show') }}"
                        class="inline-flex items-center px-4 py-2 font-medium text-white transition duration-200 transform bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700">
                        <i class="mr-2 fas fa-file-export"></i> Ekspor
                    </a>
                </div>
            @endif
        </div>

        <!-- Tabel Laporan Persediaan -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="w-full overflow-hidden border-collapse rounded-lg">
                <thead class="text-xs font-semibold tracking-wider text-left text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="px-4 py-3 text-center border border-gray-300">No.</th>
                        <th class="px-4 py-3 text-center border border-gray-300">Kategori Barang</th>
                        <th class="px-4 py-3 text-center border border-gray-300">Stok Keseluruhan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($persediaans as $persediaan)
                        <tr class="transition duration-150 hover:bg-blue-50">
                            <td class="px-4 py-4 text-center text-gray-800 border border-gray-300 whitespace-nowrap">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-4 text-center text-gray-800 border border-gray-300 whitespace-nowrap">
                                {{ $persediaan->kategori }}
                            </td>
                            <td class="px-4 py-4 text-center text-gray-800 border border-gray-300 whitespace-nowrap">
                                @if ($persediaan->total_stok > 0)
                                    {{ $persediaan->total_stok / 20 }} Kodi
                                @else
                                    <div class="p-4 text-red-700 bg-red-100 border-l-4 border-red-500" role="alert">
                                        <p class="font-bold">Stok Habis</p>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3"
                                class="px-4 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                                Data Persediaan belum Tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="flex justify-center mt-6">
            {{-- {{ $persediaans->appends(request()->input())->links() }} --}}
        </div>

    </div>

</x-layout>

<x-modal-flowbite></x-modal-flowbite>
