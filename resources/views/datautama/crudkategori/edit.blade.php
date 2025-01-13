<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Edit Kategori</span>
    </h1>

    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Form Grid -->
        <div class="space-y-4">

            <!-- Nama Kategori -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kategori:</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $kategori->nama) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('nama') border-red-500 @enderror"
                    required>
                @error('nama')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('deskripsi') border-red-500 @enderror"
                    required>{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                @error('deskripsi')
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
            <a href="{{ route('kategori.index') }}"
                class="px-4 py-2 ml-4 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </form>
</x-layout>
