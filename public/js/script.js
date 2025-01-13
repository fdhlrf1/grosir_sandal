// const { data } = require("autoprefixer");

// SCRIPT UNTUK SIDEBAR TOOGLE
document.getElementById('toggle-data').addEventListener('click', function (event) {
    event.preventDefault();
    const subLinks = document.getElementById('sub-links-data');
    const icon = document.getElementById('icon-data');

    subLinks.classList.toggle('hidden');
    icon.classList.toggle('rotate-90'); // Menambahkan rotasi 90 derajat
});

document.getElementById('toggle-transaksi').addEventListener('click', function (event) {
    event.preventDefault();
    const subLinks = document.getElementById('sub-links-trs');
    const icon = document.getElementById('icon-transaksi'); // Pastikan ID ini sesuai dengan ID ikon yang digunakan

    subLinks.classList.toggle('hidden');
    icon.classList.toggle('rotate-90'); // Menambahkan rotasi 90 derajat
});
document.getElementById('toggle-pencatatan').addEventListener('click', function (event) {
    event.preventDefault();
    const subLinks = document.getElementById('sub-links-pct');
    const icon = document.getElementById('icon-pencatatan'); // Pastikan ID ini sesuai dengan ID ikon yang digunakan

    subLinks.classList.toggle('hidden');
    icon.classList.toggle('rotate-90'); // Menambahkan rotasi 90 derajat
});
document.getElementById('toggle-kelola').addEventListener('click', function (event) {
    event.preventDefault();
    const subLinks = document.getElementById('sub-links-kel');
    const icon = document.getElementById('icon-kelola'); // Pastikan ID ini sesuai dengan ID ikon yang digunakan

    subLinks.classList.toggle('hidden');
    icon.classList.toggle('rotate-90'); // Menambahkan rotasi 90 derajat
});


document.getElementById('toggle-laporan').addEventListener('click', function (event) {
    event.preventDefault();
    const subLinks = document.getElementById('sub-links-lpr');
    const icon = document.getElementById('icon-laporan'); // Pastikan ID ini sesuai dengan ID ikon yang digunakan

    subLinks.classList.toggle('hidden');
    icon.classList.toggle('rotate-90'); // Menambahkan rotasi 90 derajat
});
// SCRIPT UNTUK CHECK WARNA LAINNYA
function checkWarnaOption(selectElement) {
    var selectedValue = selectElement.value;
    var warnaLainnyaDiv = document.getElementById('warnaLainnyaDiv');
    var warnaLainnyaInput = document.getElementById('warnaLainnya');

    if (selectedValue === 'lainnya') {
        // Tampilkan input teks untuk warna lainnya
        warnaLainnyaDiv.classList.remove('hidden');
        warnaLainnyaInput.focus(); // Fokus pada input teks
    } else {
        // Sembunyikan input teks untuk warna lainnya
        warnaLainnyaDiv.classList.add('hidden');
        warnaLainnyaInput.value = ''; // Kosongkan input jika bukan warna lainnya
    }
}

// SCRIPT UNTUK UNTUK MODAL PENJUALAN
document.addEventListener('DOMContentLoaded', function () {
    var cariBarangButton = document.getElementById('cariBarangButton');
    var modal = document.getElementById('modal');
    var closeModal = document.getElementById('closeModal');
    var selectButtons = document.querySelectorAll('.select-barang');

    cariBarangButton.addEventListener('click', function () {
        modal.classList.remove('hidden');
        setTimeout(function () {
            modal.classList.remove('opacity-0', 'scale-95');
            modal.classList.add('opacity-100', 'scale-100');
        }, 10); // Small delay to apply transition
    });

    closeModal.addEventListener('click', function () {
        modal.classList.remove('opacity-100', 'scale-100');
        modal.classList.add('opacity-0', 'scale-95');
        setTimeout(function () {
            modal.classList.add('hidden');
        }, 300); // Duration of the animation
    });

    // Event listener untuk tombol pilih barang
    selectButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var kode = button.getAttribute('data-kode');
            var kategori = button.getAttribute('data-kategori');
            var motif = button.getAttribute('data-motif');
            var size = button.getAttribute('data-size');
            var warna = button.getAttribute('data-warna');
            // var satuan = button.getAttribute('data-satuan');
            var pemasok = button.getAttribute('data-pemasok');
            var h_beli = button.getAttribute('data-h_beli');
            var h_jual = button.getAttribute('data-h_jual');
            var stok = button.getAttribute('data-stok');
            // var gambar = button.getAttribute('data-gambar');

            // Pastikan elemen ada sebelum mencoba mengatur nilainya
            var kdBarangInput = document.getElementById('kd_barang');
            var kategoriInput = document.getElementById('kategori');
            var motifInput = document.getElementById('motif');
            var warnaSelect = document.getElementById('warna');
            var sizeInput = document.getElementById('id_ukuran');
            // var satuanInput = document.getElementById('id_satuan');
            var pemasokSelect = document.getElementById('id_pemasok');
            var hargabeliInput = document.getElementById('h_beli');
            var hargajualInput = document.getElementById('h_jual');
            var stokInput = document.getElementById('stok');
            // var imgPreview = document.getElementById('gambarPreview');

            if (kdBarangInput) kdBarangInput.value = kode;
            if (kategoriInput) kategoriInput.value = kategori;
            if (motifInput) motifInput.value = motif;
            if (warnaSelect) warnaSelect.value = warna;
            if (sizeInput) sizeInput.value = size;
            // if (satuanInput) satuanInput.value = satuan;
            if (pemasokSelect) pemasokSelect.value = pemasok;
            if (hargabeliInput) hargabeliInput.value = h_beli;
            if (hargajualInput) hargajualInput.value = h_jual;
            if (stokInput) stokInput.value = stok;

            // Menutup modal setelah memilih barang
            modal.classList.remove('opacity-100', 'scale-100');
            modal.classList.add('opacity-0', 'scale-95');
            setTimeout(function () {
                modal.classList.add('hidden');
            }, 300); // Duration of the animation
        });
    });


});

// SCRIPT UNTUK UNTUK MODAL PEMBELIAN
document.addEventListener('DOMContentLoaded', function () {
    var cariBarangButton2 = document.getElementById('cariBarangButton2');
    var modal2 = document.getElementById('modal2');
    var closeModal2 = document.getElementById('closeModal2');
    var selectButtons2 = document.querySelectorAll('.select-barang');

    cariBarangButton2.addEventListener('click', function () {
        modal2.classList.remove('hidden');
        setTimeout(function () {
            modal2.classList.remove('opacity-0', 'scale-95');
            modal2.classList.add('opacity-100', 'scale-100');
        }, 10); // Small delay to apply transition
    });

    closeModal2.addEventListener('click', function () {
        modal2.classList.remove('opacity-100', 'scale-100');
        modal2.classList.add('opacity-0', 'scale-95');
        setTimeout(function () {
            modal2.classList.add('hidden');
        }, 300); // Duration of the animation
    });

    // Event listener untuk tombol pilih barang
    selectButtons2.forEach(function (button) {
        button.addEventListener('click', function () {
            var kode = button.getAttribute('data-kode');
            var kategori = button.getAttribute('data-kategori');
            var motif = button.getAttribute('data-motif');
            var size = button.getAttribute('data-size');
            var warna = button.getAttribute('data-warna');
            var satuan = button.getAttribute('data-satuan');
            var pemasok = button.getAttribute('data-pemasok');
            var h_beli = button.getAttribute('data-h_beli');
            var h_jual = button.getAttribute('data-h_jual');
            var gambar = button.getAttribute('data-gambar');

            // Pastikan elemen ada sebelum mencoba mengatur nilainya
            var kdBarangInput = document.getElementById('kd_barang');
            var kategoriSelect = document.getElementById('id_kategori');
            var motifSelect = document.getElementById('id_motif');
            var warnaSelect = document.getElementById('warna');
            var sizeInput = document.getElementById('id_ukuran');
            var satuanSelect = document.getElementById('id_satuan');
            var pemasokSelect = document.getElementById('id_pemasok');
            var hargabeliInput = document.getElementById('h_beli');
            var hargajualInput = document.getElementById('h_jual');
            var imgPreview = document.getElementById('gambarPreview');
            // var inputFile = document.getElementById('gambar');

            if (gambar) {
                var imageUrl = baseUrl + '/' + gambar;
                imgPreview.src = imageUrl;
                imgPreview.classList.remove('hidden');

                inputFile.disabled = true
            } else {
                imgPreview.src = '';
                imgPreview.classList.add('hidden');
            }


            // Set input dan select menjadi readonly dan beri kelas abu-abu
            if (kdBarangInput) {
                kdBarangInput.value = kode;
                kdBarangInput.readOnly = true;
                kdBarangInput.classList.add('bg-gray-200'); // Ganti dengan kelas CSS yang sesuai
            }
            if (sizeInput) {
                sizeInput.value = size;
                sizeInput.readOnly = true;
                sizeInput.classList.add('bg-gray-200');
            }
            if (hargabeliInput) {
                hargabeliInput.value = h_beli;
                hargabeliInput.readOnly = true;
                hargabeliInput.classList.add('bg-gray-200');
            }
            if (hargajualInput) {
                hargajualInput.value = h_jual;
                hargajualInput.readOnly = true;
                hargajualInput.classList.add('bg-gray-200');
            }

            // Update kategoriSelect dengan kategori yang dipilih
            if (kategoriSelect) {
                // Hapus semua opsi sebelumnya
                kategoriSelect.innerHTML = '';

                var newOption = document.createElement('option');
                newOption.value = kategori; // Mengasumsikan kode adalah ID kategori
                newOption.textContent = kategori; // Tampilkan nama kategori
                kategoriSelect.appendChild(newOption);
                kategoriSelect.setAttribute('readonly', true); // Jadikan readonly
                kategoriSelect.classList.add('bg-gray-200');
            }
            if (satuanSelect) {
                satuanSelect.innerHTML = '';

                var newOption = document.createElement('option');
                newOption.value = satuan;
                newOption.textContent = satuan;
                satuanSelect.appendChild(newOption);
                satuanSelect.setAttribute('readonly', true); // Jadikan readonly
                satuanSelect.classList.add('bg-gray-200');
            }
            if (motifSelect) {
                motifSelect.innerHTML = '';

                var newOption = document.createElement('option');
                newOption.value = motif;
                newOption.textContent = motif;
                motifSelect.appendChild(newOption);
                motifSelect.setAttribute('readonly', true); // Jadikan readonly
                motifSelect.classList.add('bg-gray-200');
            }
            if (pemasokSelect) {
                pemasokSelect.innerHTML = '';

                var newOption = document.createElement('option');
                newOption.value = pemasok;
                newOption.textContent = pemasok;
                pemasokSelect.appendChild(newOption);
                pemasokSelect.setAttribute('readonly', true); // Jadikan readonly
                pemasokSelect.classList.add('bg-gray-200');
            }
            if (warnaSelect) {
                warnaSelect.innerHTML = '';

                var newOption = document.createElement('option');
                newOption.value = warna;
                newOption.textContent = warna;
                warnaSelect.appendChild(newOption);
                warnaSelect.setAttribute('readonly', true); // Jadikan readonly
                warnaSelect.classList.add('bg-gray-200');
            }

            // Menutup modal setelah memilih barang
            modal2.classList.remove('opacity-100', 'scale-100');
            modal2.classList.add('opacity-0', 'scale-95');
            setTimeout(function () {
                modal2.classList.add('hidden');
            }, 300); // Duration of the animation
        });
    });

});


// SCRIPT UNTUK UNTUK MODAL detail
// document.addEventListener('DOMContentLoaded', function () {
//     var detailBarang = document.getElementById('detailBarang');
//     var modal3 = document.getElementById('modal3');
//     var closeModal3 = document.getElementById('closeModal3');
//     var selectButtons3 = document.querySelectorAll('.select-barang');

//     detailBarang.addEventListener('click', function () {
//         modal3.classList.remove('hidden');
//         setTimeout(function () {
//             modal3.classList.remove('opacity-0', 'scale-95');
//             modal3.classList.add('opacity-100', 'scale-100');
//         }, 10); // Small delay to apply transition
//     });

//     closeModal3.addEventListener('click', function () {
//         modal3.classList.remove('opacity-100', 'scale-100');
//         modal3.classList.add('opacity-0', 'scale-95');
//         setTimeout(function () {
//             modal3.classList.add('hidden');
//         }, 300); // Duration of the animation
//     });

//     // Event listener untuk tombol pilih barang
//     selectButtons3.forEach(function (button) {
//         button.addEventListener('click', function () {
//             var kode = button.getAttribute('data-kode');
//             var kategori = button.getAttribute('data-kategori');
//             var motif = button.getAttribute('data-motif');
//             var size = button.getAttribute('data-size');
//             var satuan = button.getAttribute('data-satuan');
//             var stok = button.getAttribute('data-stok');
//             var h_jual = button.getAttribute('data-h_jual');

//             // Pastikan elemen ada sebelum mencoba mengatur nilainya
//             var kdBarangInput = document.getElementById('kd_barang');
//             var kategoriInput = document.getElementById('kategori');
//             var motifInput = document.getElementById('motif');
//             var sizeInput = document.getElementById('size');
//             var satuanInput = document.getElementById('satuan');
//             var stokInput = document.getElementById('stok');
//             var hargaInput = document.getElementById('h_jual');

//             if (kdBarangInput) kdBarangInput.value = kode;
//             if (kategoriInput) kategoriInput.value = kategori;
//             if (motifInput) motifInput.value = motif;
//             if (sizeInput) sizeInput.value = size;
//             if (satuanInput) satuanInput.value = satuan;
//             if (stokInput) stokInput.value = stok;
//             if (hargaInput) hargaInput.value = h_jual;

//             // Menutup modal3 setelah memilih barang
//             modal3.classList.remove('opacity-100', 'scale-100');
//             modal3.classList.add('opacity-0', 'scale-95');
//             setTimeout(function () {
//                 modal3.classList.add('hidden');
//             }, 300); // Duration of the animation
//         });
//     });


// });


// Menambahkan event listener ke semua tombol detail-item-button
document.querySelectorAll('.detail-item-button').forEach(button => {
    button.addEventListener('click', function () {
        // Ambil nilai 'key' dari atribut data-key pada tombol
        const key = this.getAttribute('data-key');
        console.log('Tombol detail diklik dengan key:', key);

        // Kirim request ke server menggunakan fetch
        fetch(itemDetailsUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken  // Menggunakan CSRF token dari Blade
            },
            body: JSON.stringify({ key: key })  // Mengirim 'key' dalam format JSON
        })
            .then(response => {
                console.log('Respons status:', response.status);  // Log status respons dari server
                return response.json();  // Parse respons menjadi JSON
            })
            .then(data => {
                console.log('Data barang:', data);  // Tampilkan data barang di console

                // Jika terjadi error, tampilkan pesan error di dalam modal
                if (data.error) {
                    document.querySelector('#modal3 tbody').innerHTML = `
                <tr>
                    <td colspan="2" class="px-4 py-2 text-center text-red-700 bg-red-100">Detail tidak ditemukan</td>
                </tr>`;
                } else {
                    // Render data barang di dalam modal
                    document.querySelector('#modal3 tbody').innerHTML = `
                <tr class="border-b">
                    <td class="px-1 py-2 font-semibold">Harga Beli:</td>
                    <td class="px-1 py-2">Rp. ${new Intl.NumberFormat('id-ID').format(data.h_beli)}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-1 py-2 font-semibold">Warna:</td>
                    <td class="px-1 py-2">${data.warna}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-1 py-2 font-semibold">Size:</td>
                    <td class="px-1 py-2">${data.size}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-1 py-2 font-semibold">Motif:</td>
                    <td class="px-1 py-2">${data.motif_nama}</td>
                </tr>
                <tr class="border-b">
                    <td class="px-1 py-2 font-semibold">Pemasok:</td>
                    <td class="px-1 py-2">${data.pemasok_nama}</td>
                </tr>`;
                }

                // Menampilkan modal
                const modal = document.getElementById('modal3');
                modal.classList.remove('hidden', 'opacity-0', 'scale-95');
            })
            .catch(error => {
                console.error('Error fetching item details:', error);  // Log error jika ada
            });
    });
});


// Fungsi untuk menutup modal saat tombol "Tutup" diklik
document.getElementById('closeModal3').addEventListener('click', function () {
    document.getElementById('modal3').classList.add('hidden', 'opacity-0', 'scale-95');  // Menyembunyikan modal
});






//SCRIPT UNTUK AJAX MENAMPILKAN SIZE KETIKA KATEGORI DIPILIH
document.addEventListener('DOMContentLoaded', function () {
    var kategoriSelect = document.getElementById('id_kategori');
    var ukuranInput = document.getElementById('id_ukuran');
    var motifSelect = document.getElementById('id_motif');

    kategoriSelect.addEventListener('change', function () {
        var idKategori = kategoriSelect.value;

        // Reset input ukuran sebelum fetch
        ukuranInput.value = 'Loading...';

        // Fetch data ukuran berdasarkan kategori yang dipilih
        fetch(`/get-ukuran/${idKategori}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    // Gabungkan semua ukuran yang diterima ke dalam satu string
                    ukuranInput.value = data.join(', ');
                } else {
                    ukuranInput.value = 'Ukuran tidak tersedia';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                ukuranInput.value = 'Error loading data...';
            });


        //Fetch Motif berdasarkan kategori
        motifSelect.innerHTML = '<option value="" disabled selected>Loading...</option>'; // menyetel pemberitahuan loading
        fetch(`/get-motif/${idKategori}`).then(response => response.json()).then(data => {
            // Hapus opsi sebelumnya
            motifSelect.innerHTML = '<option value="" disabled selected>Pilih motif...</option>';

            // Tambahkan opsi motif baru dari hasil query
            for (const id_motif in data) {
                const option = document.createElement('option');
                option.value = id_motif;
                option.textContent = data[id_motif];
                motifSelect.appendChild(option);
            }
        })
            .catch(error => {
                console.error('Error fetching motif:', error);
                motifSelect.innerHTML = '<option value="" disabled selected>Error loading motif...</option>';
            });
    });
});






