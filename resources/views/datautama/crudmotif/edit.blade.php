<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Edit Motif</span>
    </h1>

    <form action="{{ route('motif.update', $motif->id_motif) }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Form Grid -->
        <div class="space-y-4">

            <!-- Nama Kategori -->
            <div>
                <label for="nama_motif" class="block text-sm font-medium text-gray-700">Nama Motif:</label>
                <input type="text" name="nama_motif" id="nama_motif"
                    value="{{ old('nama_motif', $motif->nama_motif) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('nama_motif') border-red-500 @enderror"
                    required>
                @error('nama_motif')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="col-span-2 sm:col-span-1">
                <label for="id_kategori"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                <select id="id_kategori" name="id_kategori"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}"
                            {{ $kategori->id_kategori == $motif->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan Perubahan
            </button>
            <a href="{{ route('motif.index') }}"
                class="px-4 py-2 ml-4 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </form>
</x-layout>
