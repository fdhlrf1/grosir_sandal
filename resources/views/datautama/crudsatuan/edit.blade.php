<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Edit Satuan</span>
    </h1>

    <form action="{{ route('satuan.update', $satuan->id_satuan) }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Form Grid -->
        <div class="space-y-4">

            <!-- Nama Satuan -->
            <div>
                <label for="nama_satuan" class="block text-sm font-medium text-gray-700">Nama Satuan:</label>
                <input type="text" name="nama_satuan" id="nama_satuan"
                    value="{{ old('nama_satuan', $satuan->nama_satuan) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('nama_satuan') border-red-500 @enderror"
                    required>
                @error('nama_satuan')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konversian Ke Pcs -->
            <div>
                <label for="konversi" class="block text-sm font-medium text-gray-700">Nilai Konversi:</label>
                <input type="number" name="konversi" id="konversi" value="{{ old('konversi', $satuan->konversi) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('konversi') border-red-500 @enderror"
                    required>
                @error('konversi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan Perubahan
            </button>
            <a href="{{ route('satuan.index') }}"
                class="px-4 py-2 ml-4 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </form>
</x-layout>
