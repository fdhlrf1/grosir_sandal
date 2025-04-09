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
<h3 class="code-line" data-line-start=23 data-line-end=24 ><a id="_Prasyarat_23"></a>💡 Prasyarat</h3>
<p class="has-line-data" data-line-start="25" data-line-end="26">Sebelum memulai, pastikan kamu sudah menginstall:</p>
<p class="has-line-data" data-line-start="27" data-line-end="33">Komponen    Versi Minimum   Keterangan<br>
🐘 PHP  &gt;= 8.1  Disarankan versi terbaru<br>
🎼 Composer -   Untuk mengelola dependensi PHP<br>
🧰 Node.js  -   Digunakan bersama Tailwind + Vite<br>
📦 npm  -   Biasanya sudah include di Node.js<br>
🐬 MySQL / 🐳 MariaDB   -   Untuk database aplikasi</p>
<hr>
<h2 class="code-line" data-line-start=36 data-line-end=37 ><a id="_Instalasi_dan_Konfigurasi_36"></a>🚀 Instalasi dan Konfigurasi</h2>
<h3 class="code-line" data-line-start=38 data-line-end=39 ><a id="_1_Clone_Project_38"></a>🧱 1. Clone Project</h3>
<pre><code class="has-line-data" data-line-start="41" data-line-end="44" class="language-bash">git <span class="hljs-built_in">clone</span> https://github.com/username-kamu/nama-repo.git
<span class="hljs-built_in">cd</span> nama-repo
</code></pre>
<h3 class="code-line" data-line-start=45 data-line-end=46 ><a id="_2_Install_Depedency_45"></a>📦 2. Install Depedency</h3>
<pre><code class="has-line-data" data-line-start="47" data-line-end="50" class="language-bash">composer install
npm install
</code></pre>
<h3 class="code-line" data-line-start=51 data-line-end=52 ><a id="_3_Setup_File_env_51"></a>⚙️ 3. Setup File <code>.env</code></h3>
<pre><code class="has-line-data" data-line-start="53" data-line-end="55" class="language-bash">cp .env.example .env
</code></pre>
<h3 class="code-line" data-line-start=56 data-line-end=57 ><a id="_4_Konfigurasi_File_env_56"></a>🛠️ 4. Konfigurasi File <code>.env</code></h3>
<p class="has-line-data" data-line-start="58" data-line-end="59">Setelah menyalin file <code>.env</code>, pastikan kamu mengatur konfigurasi dasar seperti berikut:</p>
<pre><code class="has-line-data" data-line-start="61" data-line-end="71" class="language-env">APP_NAME=&quot;Grosir Sandal&quot;
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=grosirsandal
DB_USERNAME=root
DB_PASSWORD=
</code></pre>
<p class="has-line-data" data-line-start="71" data-line-end="72">⚠️ Pastikan nama database (DB_DATABASE) sudah dibuat di MySQL kamu sebelum menjalankan migrasi.</p>
<h3 class="code-line" data-line-start=73 data-line-end=74 ><a id="_5_Generate_Key_73"></a>🔐 5. Generate Key</h3>
<pre><code class="has-line-data" data-line-start="75" data-line-end="77" class="language-bash">php artisan key:generate
</code></pre>
<h3 class="code-line" data-line-start=78 data-line-end=79 ><a id="_6_Setup_Database_78"></a>🗄 6. Setup Database</h3>
<pre><code class="has-line-data" data-line-start="80" data-line-end="82" class="language-bash">php artisan migrate --seed
</code></pre>
<h3 class="code-line" data-line-start=83 data-line-end=84 ><a id="_7_Compile_Aset_Frontend_TailwindCSS__Vite_83"></a>🌐 7. Compile Aset Frontend (TailwindCSS &amp; Vite)</h3>
<pre><code class="has-line-data" data-line-start="85" data-line-end="87" class="language-bash">npm run dev
</code></pre>
<h3 class="code-line" data-line-start=88 data-line-end=89 ><a id="_8_Link_Storage_88"></a>🔗 8. Link Storage</h3>
<pre><code class="has-line-data" data-line-start="90" data-line-end="92" class="language-bash">php artisan storage:link
</code></pre>
<h3 class="code-line" data-line-start=93 data-line-end=94 ><a id="_9_Jalankan_Project_93"></a>▶️ 9. Jalankan Project</h3>
<pre><code class="has-line-data" data-line-start="95" data-line-end="97" class="language-bash">php artisan serve
</code></pre>
<h2 class="code-line" data-line-start=98 data-line-end=99 ><a id="Lisensi_98"></a>Lisensi</h2>
<p class="has-line-data" data-line-start="100" data-line-end="101">The Laravel framework is open-sourced software licensed under the <a href="https://opensource.org/licenses/MIT">MIT license</a>.</p>
<h2 class="code-line" data-line-start=102 data-line-end=103 ><a id="_Kredit_102"></a>Kredit</h2>
<p class="has-line-data" data-line-start="103" data-line-end="104">Proyek ini dikembangkan oleh:</p>
<p class="has-line-data" data-line-start="105" data-line-end="108">👤 Fadhil Rafi Fauzan<br>
📧 Email: [fadhilrafifauzan.17@gmail.com]<br>
🐙 GitHub: <a href="http://github.com/fdhlrf.1">github.com/fdhlrf.1</a></p>
<p class="has-line-data" data-line-start="109" data-line-end="111">© 2024 Grosir Sandal — Hak Cipta Dilindungi Undang-Undang.<br>
Terima kasih telah menggunakan aplikasi ini! ⭐</p>
