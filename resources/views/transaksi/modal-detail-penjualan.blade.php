<!-- Modal untuk menampilkan detail barang -->
<div id="modal3"
    class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity duration-300 ease-in-out transform scale-95 bg-gray-900 bg-opacity-50 opacity-0">
    <div class="w-6/12 max-w-4xl max-h-screen p-6 overflow-y-auto bg-white rounded-md">
        <h3 class="mb-4 text-xl font-semibold">Detail Barang</h3>

        <!-- Tabel untuk menampilkan detail barang -->
        <table class="w-full border-collapse table-auto">
            <tbody>
                <!-- Tempat untuk data barang diisi oleh AJAX-->
                <tr>
                    <td colspan="2" class="px-4 py-2 text-center text-gray-600">Memuat data barang...</td>
                </tr>
            </tbody>
        </table>

        <!-- Tombol Tutup dan Pilih Lagi -->
        <div class="flex justify-end mt-4 space-x-4">
            <button id="closeModal3" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Tutup</button>
            {{-- <button id="pilihLagi" class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600">Pilih
                Lagi</button> --}}
        </div>
    </div>
</div>
