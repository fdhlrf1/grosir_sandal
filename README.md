<h1 class="code-line" data-line-start=0 data-line-end=1 ><a id="_Aplikasi_Penjualan_Grosir_Sandal_New_Spon_0"></a>🛒 Aplikasi Penjualan Grosir Sandal New Spon</h1>
<p class="has-line-data" data-line-start="2" data-line-end="8"><img src="https://img.shields.io/badge/Laravel-10.x-red" alt="Laravel Version"><br>
<img src="https://img.shields.io/badge/PHP-%5E8.1-blue" alt="PHP Version"><br>
<img src="https://img.shields.io/badge/Style-TailwindCSS-38bdf8" alt="TailwindCSS"><br>
<img src="https://img.shields.io/badge/Database-MySQL-yellow?logo=mysql" alt="MySQL"><br>
<img src="https://img.shields.io/badge/Test%20Coverage-90%25-brightgreen" alt="Coverage"><br>
<img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License: MIT"></p>
<p class="has-line-data" data-line-start="9" data-line-end="10">Aplikasi manajemen grosir sandal berbasis Laravel. Cocok untuk mendata penjualan, pencatatan barang (re-stock), laporan penjualan, laporan pembelian per periode, pembuatan nota untuk pembeli, dan pendataan piu</p>
<hr>
<h2 class="code-line" data-line-start=13 data-line-end=14 ><a id="_Fitur_Utama_13"></a>🛠️ Fitur Utama</h2>
<ul>
<li class="has-line-data" data-line-start="15" data-line-end="16">✅ Manajemen Data Barang (Kategori, Motif, Ukuran, Satuan)</li>
<li class="has-line-data" data-line-start="16" data-line-end="17">✅ Manajemen Stok</li>
<li class="has-line-data" data-line-start="17" data-line-end="18">✅ Transaksi Penjualan Barang</li>
<li class="has-line-data" data-line-start="18" data-line-end="19">✅ Pencatatan Pembelian Barang</li>
<li class="has-line-data" data-line-start="19" data-line-end="21">✅ Pendataan Piutang Konsumen</li>
</ul>
<hr>
<h2 class="code-line" data-line-start=23 data-line-end=24 ><a id="_Prasyarat_23"></a>💡 Prasyarat</h2>
<p class="has-line-data" data-line-start="25" data-line-end="26">Sebelum memulai, pastikan kamu sudah menginstall:</p>
<ul>
<li class="has-line-data" data-line-start="27" data-line-end="28">🐘 PHP    &gt;= 8.1  Disarankan versi terbaru</li>
<li class="has-line-data" data-line-start="28" data-line-end="29">🎼 Composer   -   Untuk mengelola dependensi PHP</li>
<li class="has-line-data" data-line-start="29" data-line-end="30">🧰 Node.js    -   Digunakan bersama Tailwind + Vite</li>
<li class="has-line-data" data-line-start="30" data-line-end="31">📦 npm    -   Biasanya sudah include di Node.js</li>
<li class="has-line-data" data-line-start="31" data-line-end="33">🐬 MySQL / 🐳 MariaDB -   Untuk database aplikasi</li>
</ul>
<hr>
<h2 class="code-line" data-line-start=35 data-line-end=36 ><a id="_Instalasi_dan_Konfigurasi_35"></a>🚀 Instalasi dan Konfigurasi</h2>
<h3 class="code-line" data-line-start=37 data-line-end=38 ><a id="_1_Clone_Project_37"></a>🧱 1. Clone Project</h3>
<pre><code class="has-line-data" data-line-start="40" data-line-end="43" class="language-bash">git <span class="hljs-built_in">clone</span> https://github.com/username-kamu/nama-repo.git
<span class="hljs-built_in">cd</span> nama-repo
</code></pre>
<h3 class="code-line" data-line-start=44 data-line-end=45 ><a id="_2_Install_Depedency_44"></a>📦 2. Install Depedency</h3>
<pre><code class="has-line-data" data-line-start="46" data-line-end="49" class="language-bash">composer install
npm install
</code></pre>
<h3 class="code-line" data-line-start=50 data-line-end=51 ><a id="_3_Setup_File_env_50"></a>⚙️ 3. Setup File <code>.env</code></h3>
<pre><code class="has-line-data" data-line-start="52" data-line-end="54" class="language-bash">cp .env.example .env
</code></pre>
<h3 class="code-line" data-line-start=55 data-line-end=56 ><a id="_4_Konfigurasi_File_env_55"></a>🛠️ 4. Konfigurasi File <code>.env</code></h3>
<p class="has-line-data" data-line-start="57" data-line-end="58">Setelah menyalin file <code>.env</code>, pastikan kamu mengatur konfigurasi dasar seperti berikut:</p>
<pre><code class="has-line-data" data-line-start="60" data-line-end="70" class="language-env">APP_NAME=&quot;Grosir Sandal&quot;
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=grosirsandal
DB_USERNAME=root
DB_PASSWORD=
</code></pre>
<p class="has-line-data" data-line-start="70" data-line-end="71">⚠️ Pastikan nama database (DB_DATABASE) sudah dibuat di MySQL kamu sebelum menjalankan migrasi.</p>
<h3 class="code-line" data-line-start=72 data-line-end=73 ><a id="_5_Generate_Key_72"></a>🔐 5. Generate Key</h3>
<pre><code class="has-line-data" data-line-start="74" data-line-end="76" class="language-bash">php artisan key:generate
</code></pre>
<h3 class="code-line" data-line-start=77 data-line-end=78 ><a id="_6_Setup_Database_77"></a>🗄 6. Setup Database</h3>
<pre><code class="has-line-data" data-line-start="79" data-line-end="81" class="language-bash">php artisan migrate --seed
</code></pre>
<h3 class="code-line" data-line-start=82 data-line-end=83 ><a id="_7_Compile_Aset_Frontend_TailwindCSS__Vite_82"></a>🌐 7. Compile Aset Frontend (TailwindCSS &amp; Vite)</h3>
<pre><code class="has-line-data" data-line-start="84" data-line-end="86" class="language-bash">npm run dev
</code></pre>
<h3 class="code-line" data-line-start=87 data-line-end=88 ><a id="_8_Link_Storage_87"></a>🔗 8. Link Storage</h3>
<pre><code class="has-line-data" data-line-start="89" data-line-end="91" class="language-bash">php artisan storage:link
</code></pre>
<h3 class="code-line" data-line-start=92 data-line-end=93 ><a id="_9_Jalankan_Project_92"></a>▶️ 9. Jalankan Project</h3>
<pre><code class="has-line-data" data-line-start="94" data-line-end="96" class="language-bash">php artisan serve
</code></pre>
<hr>
<h2 class="code-line" data-line-start=99 data-line-end=100 ><a id="_Akun_Login_Default_99"></a>🔐 Akun Login Default</h2>
<p class="has-line-data" data-line-start="101" data-line-end="102">Setelah proses seeding selesai (<code>php artisan migrate --seed</code>), kamu dapat login ke aplikasi menggunakan akun berikut:</p>
<table class="table table-striped table-bordered">
<thead>
<tr>
<th>Role</th>
<th>Username</th>
<th>Password</th>
<th>Nama Toko</th>
</tr>
</thead>
<tbody>
<tr>
<td>Admin</td>
<td>admin</td>
<td>admin</td>
<td>New Spon</td>
</tr>
<tr>
<td>Kasir</td>
<td>petugas</td>
<td>petugas</td>
<td>New Spon</td>
</tr>
<tr>
<td>Admin</td>
<td>admin2</td>
<td>admin2</td>
<td>New Spon 2</td>
</tr>
<tr>
<td>Kasir</td>
<td>petugas2</td>
<td>petugas2</td>
<td>New Spon 2</td>
</tr>
</tbody>
</table>
<p class="has-line-data" data-line-start="110" data-line-end="111">⚠️ <strong>Penting:</strong> Pastikan untuk segera mengganti password akun-akun default ini demi keamanan, terutama jika aplikasi diunggah ke server publik.</p>
<hr>
<h2 class="code-line" data-line-start=114 data-line-end=115 ><a id="Lisensi_114"></a>Lisensi</h2>
<p class="has-line-data" data-line-start="116" data-line-end="117">The Laravel framework is open-sourced software licensed under the <a href="https://opensource.org/licenses/MIT">MIT license</a>.</p>
<h2 class="code-line" data-line-start=118 data-line-end=119 ><a id="Kredit_118"></a>Kredit</h2>
<p class="has-line-data" data-line-start="119" data-line-end="120">Proyek ini dikembangkan oleh:</p>
<ul>
<li class="has-line-data" data-line-start="121" data-line-end="122">👤 Fadhil Rafi Fauzan</li>
<li class="has-line-data" data-line-start="122" data-line-end="123">📧 Email: [fadhilrafifauzan.17@gmail.com]</li>
<li class="has-line-data" data-line-start="123" data-line-end="125">🐙 GitHub: <a href="http://github.com/fdhlrf.1">github.com/fdhlrf.1</a></li>
</ul>
<p class="has-line-data" data-line-start="125" data-line-end="127">© 2024 Grosir Sandal — Hak Cipta Dilindungi Undang-Undang.<br>
Terima kasih telah menggunakan aplikasi ini! ⭐</p>
