# Aplikasi Monitoring Bayi dan Balita (Sistem Informasi Posyandu)

Aplikasi Monitoring Bayi adalah platform Sistem Informasi Kesehatan (berbasis Web) yang dirancang untuk memfasilitasi pencatatan, pemantauan status gizi (stunting), imunisasi, serta pelaporan berjenjang dari tingkat Posyandu (Kader & Bidan) hingga Dinas Kesehatan (Dinkes). Orang tua juga difasilitasi dasbor khusus untuk memantau rekam medis dan tumbuh kembang anak mereka kapan pun dan di mana pun.

Proyek ini dibangun sebagai penyelesaian Tugas Akhir dengan menggunakan framework modern Laravel 13 dan Tailwind CSS 4.

## 🚀 Fitur Utama & Dashboard Role

Aplikasi ini menggunakan kontrol akses berbasis *Role* (Role-Based Access Control) yang sangat komprehensif. Berikut adalah rincian fungsionalitas dan fitur spesifik yang terdapat pada Dashboard masing-masing aktor:

### 1. Super Admin
Pemegang hak akses penuh terhadap konfigurasi sistem pengguna tingkat atas.
- **Dashboard Ringkas**: Menampilkan rekapitulasi data pengguna.
- **Manajemen Data Pengguna (CRUD)**: Dapat melihat, menambah, memperbarui, dan menghapus seluruh tipe pengguna.
- **Manajemen Profil Pribadi**: Pembaruan profil admin.

### 2. Bidan (Tenaga Kesehatan)
Berfungsi sebagai ujung tombak validasi medis anak dan supervisi Kader di wilayah Puskesmas/Posyandu terkait.
- **Dashboard Pemantauan Spesifik**: Menyajikan pemantauan menyeluruh mencakup angka anak berdasarkan status **Berat Badan (Kurang/Normal/Beresiko)**, rincian kelengkapan **Tindakan Medis & Imunisasi bayi per periode**, serta statistik pelaporan dari Posyandu wilayah operasional Bidan bersangkutan.
- **Manajemen Data Anak & Pasien**: Akses langsung untuk membaca, mengubah, dan menganalisis rekam kesehatan.
- **Pencatatan Tindakan Medis & Imunisasi**: Fitur utama untuk entri (CRUD) **Tindakan Medis** serta pendataan **Imunisasi**.
- **Notifikasi Multi-Channel (Sistem & WhatsApp)**: Dapat melakukan Push Notifikasi / Reminder melalui aplikasi Sistem secara real-time, dan mem-forward **Hasil Pemeriksaan Medis Anak via WhatsApp (WA)** langsung ke nomor Orang Tua secara otomatis (modifikasi pada handler pengiriman pesan).
- **Manajemen Akun Kader (Delegasi)**: Menambah (Create), memperbarui, menghapus, atau melihat spesifik data partisipan *Kader* yang bekerja di jangkauan wilayahnya.
- **Ekspor Dokumen Kesehatan (PDF)**: Bidan dapat memproses riwayat medis kapan pun menjadi dokumen format PDF untuk keperluan fisik/cetak.
- **Manajemen Laporan Bulanan (Dinkes & Ekspor Multi-Format)**: Bidan bertugas mengakumulasi Laporan Kesehatan: kemudian dapat mencetaknya (Print), menyimpannya dalam wujud file **Microsoft Excel**, lalu tombol final untuk me-**Submit Laporan** rutin resmi ke entitas Dinas Kesehatan.

### 3. Kader Posyandu
Membantu pendaftaran pendataan administratif, pencatatan pengukuran fisik, & sosialisasi agenda kegiatan.
- **Dashboard Operasional Kader**: Menampilkan pintasan menu esensial Posyandu, jadwal terbaru yang digawangi, serta pemantauan list dan peringatan **Status Bayi Beresiko / Stunting** di wilayah Posyandu binaannya.
- **Manajemen Pengukuran Fisik Bulanan**: Melaporkan catatan timbangan berat, pengukuran tinggi, dsb. secara instan pada hari posyandu berjalan.
- **Penjadwalan Posyandu (CRUD Agenda)**: Fitur peluncuran jadwal terarah per-periode agar muncul bagi para orang tua pada hari terkait.
- **Manajemen Profil**: Ganti/Edit detail kader pada website.

### 4. Orang Tua
*End-user* sistem dari masyarakat dengan dasbor ramah pengguna untuk melihat pertumbuhan sang anak.
- **Dashboard Beranda Utama**: Menampilkan informasi status **prioritas bayi** secara transparan, serta rincian dan alert jadwal Posyandu terdekat. Turut disematkan pengingat cerdas interaktif yang dapat dihilangkan dengan opsi **Dismiss Reminder**.
- **Manajemen Data Anak Khusus**: Mempunyai kemewahan mendaftarkan (`create`), menambah ubahan (`edit`), dan inspeksi khusus anak-anak mereka sendiri. Pendaftaran profil ini akan dilanjuti entri oleh petugas.
- **Memeriksa Riwayat & Log Buku Medis**: Peninjauan catatan lengkap **Imunisasi** berikut **Tindakan Medis** yang dibubuhkan para Bidan di waktu berlalu.
- **Unduh dan Simpan Arsip PDF**: Fitur instan untuk mengunduh rekam medis Anak (Rekap Dokumen Imunisasi & Tindakan) dalam bentuk terproteksi PDF langsung ke handphone/PC Orang Tua.
- **Inbox Pemberitahuan Terpadu**: Modul notifikasi yang mendukung fitur aksi *'Mark all as read'*.

### 5. Dinas Kesehatan (Dinkes)
Akses sentral pimpinan di ranah daerah guna pantauan global seluruh riwayat kelurahan terikat.
- **Dashboard Eksekutif**: Tampilan angka/grafik agregat kompilasi dari banyak laporan sub-wilayah dalam naungan Dinkes.
- **Inspeksi Laporan Masuk Berjenjang**: Fitur spesial pembaca laporan kiriman *Bidan* sesuai waktu (Detail bulanan tiap Posyandu & Puskesmas bersangkutan).
- **Cetak Laporan Wilayah (PDF & Excel)**: Dinkes berhak meresmikan file Laporan gabungan posyandu ke dalam kertas fisik melalui tombol print/PDF, maupun kompilasi *Spreadsheet*.
- **Edit User Profil Dinkes**: Set pengaturan admin Dinkes itu sendiri.

---

## 🏗️ Struktur Basis Data Real Geografis (Territory Mapping)
Aplikasi memisahkan dan memproses pendaftaran/rekap berdasarkan hierarki wilayah sistematis:
`Kabupaten` ➔ `Puskesmas` ➔ `Posyandu`.  
Akun Kader, Bidan, hingga Dinas Kesehatan ter-relasi otomatis sesuai tempat pengabdiannya sebatas batasan wilayah/area mereka.

## 🛠️ Technology Stack

- **Backend / Web Framework**: [PHP 8.3+](https://www.php.net/) | [Laravel v13.0](https://laravel.com/)
- **Frontend & CSS Templating**: [Tailwind CSS v4.0](https://tailwindcss.com/) | [Vite v8.0](https://vitejs.dev/) | [Laravel Blade](https://laravel.com/docs/blade)
- **Database System**: Relasional standard *MySQL / MariaDB*
- **Report & Document Generator**: `barryvdh/laravel-dompdf` (Cetak Rekam Medis Format PDF)
- **Notifikasi Multi-Channel**: Dukungan sistem *Alert* internal dan integrasi pengiriman rekam medis berbasis WhatsApp.
- **Unit & Feature Testing Suite**: [Pest v4.6](https://pestphp.com/) | PHPUnit

## ⚙️ Prasyarat (Requirements)

Sebelum melakukan instalasi lokal di mesin Desktop/Server, pastikan prasyarat komando terpenuhi:
1. **PHP** 8.3 atau di atasnya.
2. **Composer** PHP Package Manager.
3. **Node.js** dan **NPM/Yarn** installer (Guna merangkai/build file JS/CSS).
4. Layanan Relasional Database aktif (MySQL server / MariaDB server).

## 💻 Panduan Instalasi Lokal

Langkah mudah melakukan deploy versi Localhost bagi pengembang/developer (Testing Version):

1. **Unduh Kode (Clone) Repositori Ini:**
   ```bash
   git clone <URL_REPOSITORI_ANDA>
   cd TUGAS-AKHIR-MonitoringBayi
   ```

2. **Dapatkan *Dependencies* Packages PHP dengan Composer:**
   ```bash
   composer install
   ```

3. **Install Kebutuhan Rendering Frontend *(Node Modules)*:**
   ```bash
   npm install
   ```

4. **Kloning File Setup *Environment*:**
   Salin berkas template milik Laravel, setelahnya harap ubah pengaturan *Database* dan SMTP/Email (Opsional untuk testing `MedicalResultMail`).
   ```bash
   cp .env.example .env
   ```
   *Buka `nano .env` / text editor Anda, edit kredensial dari `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` Anda.*

5. **Aktivasi APP Key Enkripsi:**
   ```bash
   php artisan key:generate
   ```

6. **Kalkulasi & Bangun Struktur Tabel Database (Lakukan Seeding Bersama):**
   *Note: Menjalankan flag `--seed` krusial sebagai fondasi awal memasukkan akun master role & daftar hierarki lokasi wilayah yang tak bisa dientri manual tanpa Super Admin awal.*
   ```bash
   php artisan migrate --seed
   ```

7. **Kompilasi Antarmuka Bundle Vite:**
   ```bash
   npm run build
   # Catatan dev live-reload: npm run dev
   ```

8. **Luncurkan Development Build di Localhost Laravel:**
   ```bash
   php artisan serve
   ```

Aplikasi sukses dinyalakan. Silakan buka Browser Anda dan pergi ke alamat rujukan IP [http://localhost:8000](http://localhost:8000).

## 📄 Lisensi Aturan Proyek
Sumber kode aplikasi / Tugas Akhir ini dikembangkan bersifat hak-terbuka / *Open Source* yang mengudara dengan paten lisensi standar global [MIT license](https://opensource.org/licenses/MIT).