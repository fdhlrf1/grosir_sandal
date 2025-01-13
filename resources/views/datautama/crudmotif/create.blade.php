<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Tambah Motif</span>
    </h1>

    <form action="{{ route('motif.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Form Fields -->
        <div class="space-y-4">

            <!-- Nama motif -->
            <div>
                <label for="nama_motif" class="block text-sm font-medium text-gray-700">Nama Motif:</label>
                <input type="text" name="nama_motif" id="nama_motif" maxlength="50"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('nama_motif') border-red-500 @enderror"
                    required>
                @error('nama_motif')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- id_kategori -->
            <div>
                <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori:</label>
                <select name="id_kategori" id="id_kategori"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('id_kategori') border-red-500 @enderror"
                    required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
                @error('id_kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan
            </button>
            <button type="reset"
                class="px-4 py-2 font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Reset
            </button>
            <a href="{{ route('motif.index') }}"
                class="px-4 py-2 ml-4 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </form>


</x-layout>
