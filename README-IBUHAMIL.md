# Sistem Informasi Pemantauan Kesehatan Ibu Hamil & Antenatal Care (Satu KIA)

Sistem Informasi Satu KIA adalah aplikasi berbasis web yang bertujuan untuk mendigitalisasi proses Antenatal Care (ANC / pemeriksaan kehamilan 12T), manajemen rujukan, serta sistem pelaporan rekapitulasi kehamilan dari Bidan kepada Dinas Kesehatan tingkat daerah. Sistem ini juga dirancang untuk dapat membantu Ibu Hamil secara mandiri agar terus terpantau dan mendapat _reminder_ pemeriksaan secara otomatis.

---

## 🛠 Technology Stack (Teknologi yang Digunakan)

Project ini dikembangkan menggunakan *tech stack* modern berikut:

* **Backend framework:** [Laravel 13](https://laravel.com/) (berjalan di atas PHP 8.3)
* **Frontend framework:** Laravel Blade template engine dengan Vite Asset Compilation.
* **Styling:** [Tailwind CSS v4](https://tailwindcss.com/)
* **Database Engine:** Default menggunakan SQLite saat pengembangan, sangat kompatibel diubah ke MySQL / PostgreSQL untuk level produksi.
* **Environment & Testing:** Pest PHP (untuk *Unit* dan *Feature Testing*).
* **Fitur Tambahan & library pendukung:**
  * `barryvdh/laravel-dompdf`: Digunakan secara ekstensif untuk ekspor laporan data dan *print report* (seperti cetak PDF Rekam Medis Pasien, Surat Rujukan Laboratorium, hingga Laporan Rekapitulasi Tahunan/Bulanan untuk Dinkes).
  * **QuickChart API Integration:** Menghasilkan Grafik interaktif visual terkait *High-Level Overview* perkembangan janin (Tinggi Fundus Uteri, DJJ, dan Berat Badan) yang disematkan di Dashboard Pasien (Ibu hamil) dan ikut diekspor ke dalam bukti Rekap PDF.
  * **Sistem Email & Notifikasi (Laravel Mailables / DB Notifications):**
    * Mengirim email otomatis untuk *Reminder / Pengingat Jadwal* pemeriksaan ANC.
    * Mengirim email *E-Rekam Medis (Rekap Pemeriksaan format PDF)*.
    * Mengirim Email Reset Password (native _Forgot Password_ Laravel auth).
    * Push-Notification _in-app_ (DB Notification) pada Dinkes saat ada laporan bulanan / tahunan baru yang dikirimkan oleh Bidan.

---

## 👥 Aktor, Hak Akses (Role), & Detail Fitur

Aplikasi ini mendistribusikan perannya ke dalam 4 tipe level *Role* agar berjalan secara terpusat dan transparan:

### 1. Super Admin 👑 (Administrator Sistem)
Berperan sebagai pengelola utama sistem basis data teratas tingkat administrasi (Akun default: `admin@satukia.com`).
* **Dashboard Analitik Administratif:** Meninjau secara _real-time_ akumulasi statistik, seperti: Total Bidan yang terdaftar, status Bidan (Aktif / Nonaktif), Total pengguna dinas kesehatan terdaftar (Aktif/Nonaktif), serta Total Pasien (Ibu Hamil) yang masuk di dalam sistem.
* **Manajemen Kredensial Pengguna (Master Data):** Memiliki wewenang master (CRUD) untuk operasi membuat, mengedit, serta menghapus akun seluruh aktor lainnya (Bidan, Dinas Kesehatan, dan Pasien/Ortu).

### 2. Bidan 👩‍⚕️ (Tenaga Kesehatan / Faskes Primer)
Aktor esensial yang bersinggungan langsung dengan pencatatan klinis dari Pasien (Ibu Hamil) di lapangan.
* **Dashboard Analitik Bidan:**
  * Metrik utama: Total pasien Ibu Hamil, kalkulasi Pasien berstatus Aktif, monitoring kumulatif Pasien berisiko Tinggi / Sangat Tinggi, serta pelacakan angka Pasien (Ibu) Meninggal Dunia.
  * **Tabel Pasien Prioritas Utama:** Menampilkan langsung Top 10 profil daftar Ibu Hamil dengan level *"Tinggi/Sangat Tinggi"* berdasarkan data pencatatan *update* terakhir, agar penanganan menjadi efektif.
* **Kelola Pasien (Rekam Medis) Ibu Hamil:** Registrasi manual RM pasien dengan parameter detail NIK, nomor BPJS, riwayat kehamilan lalu, golongan darah hingga HPL (Hari Perkiraan Lahir). Fasilitas ini juga terhubung ke fitur _broadcast_ surat via email.
* **Pemeriksaan ANC Terpadu (Antenatal Care 12T):**
  * Modul rekam medis *ongoing* mengontrol metrik valid seperti: Usia kehamilan (trimester), Pengukuran TFU, Denyut Jantung Janin (DJJ), Pemberian Imunisasi TT 1-5, Tablet Tambah Darah (TTD), serta deteksi Dini Risiko Anemia (Ringan-Tinggi).
  * **Fitur Draft & Cetak Rujukan Laboratorium:** Jika *form* masih bertahap/butuh prosedur uji laboratorium, status pasien dikunci sebagai "Draft". Fitur juga menyediakan _auto-generated_ **Surat Rujukan Lab (PDF)** dengan _checklist_ Triple Eliminasi tertaut (HIV, Sifilis, Hepatitis B).
* **Klasifikasi & Manajemen Rujukan (Otomatis & Deteksi Manual):**
  * Tiap pemeriksaan ANC yang *disubmit selesai* dengan kalkulasi berisiko (cth: LILA < 23,5 cm, HB Rendah), pasien otomotis beranjak naik pada level **Risiko Sangat Tinggi**.
  * Bidan disediakan tombol operasional **"Turun Risiko"** jika Ibu Hamil diklasifikasi mulai membaik setelah mendapat penanganan Rujukan.
* **Tracking Audit Kematian (Maternal/Bayi):** Mendukung pelaporan manual spesifik atas kasus bayi meninggal usai persalinan maupun resiko ibu meninggal. Angka yang terdata akan masuk langsung ke agregat Audit Kematian Kabupaten/Kota (Dinkes).
* **Pelaporan Integrasi (Reporting to Dinkes):**
  * Tidak perlu kalkulasi _excel_ manual, sistem menghimpun segala rekam poli bulanan maupun tahunan. Bidan tinggal menekan **"Kirim Laporan"** dan otomatis data serta _Push Notification_ (Notifikasi) berpindah ke _In-App_ milik Dinas Kesehatan.

### 3. Ibu Hamil / Orang Tua (Pasien) 🤰
Akses transparan agar pasien memiliki rasa _awareness_ dan historis pribadi atas proses kehamilannya.
* **Dashboard Pasien & Grafik Visual Interaktif:** Pada beranda log-in, Ortu disuguhkan statistik Grafik *Line Chart* Perkembangan Janin berdasarkan rekam data klinis *Tinggi Fundus Uteri (TFU)*, *Berat Badan (BB)*, dan *Detak Jantung (DJJ)* seiring berjalannya trimester.
* **Histori Rekam ANC (Riwayat Detail):** Mengakses data detil per kunjungan secara historis layaknya meninjau "Buku KIA Digital".
* **Fasilitas Download PDF (E-Rekap Pemantauan):** Mengekspor *report* utuh riwayat buku pemantauan ANC yang disertai grafik ke dalam wujud file PDF utuh yang siap cetak.

### 4. Dinas Kesehatan (Dinkes) 🏢
Akses agregatif area Kabupaten/Kota/Regional guna memonitor metrik *Big Data* kinerja dan mortalitas.
* **Dashboard Agregat Regional:** Memantau akumulasi total statistik dari segala puskesmas/bidan, terdiri dari: Total Ibu Hamil keseluruhan regional, Kasus Kematian Ibu, hingga persentase sebaran Risiko Kehamilan (kategori Rendah, Tinggi, dan Sangat Tinggi).
* **Pusat Inbox Notifikasi:** Menerima bel/pemberitahuan _real-time_ kapanpun Laporan Bidan (Bulanan/Tahunan) selesai dikirim. Laporan akan ditandai sbg 'Sudah Dibaca' bila dilihat.
* **Modul Laporan KIA (Export & Filter Data):**
  * Mendigitalisasi tabulasi spesifik untuk mengukur Indikator Kinerja Pelayanan: Deteksi capaian Kunjungan awal **K1**, Capaian Indikator Lab **Triple Eliminasi**, Capaian Pelayanan 90 hari TTD (**Tablet Tambah Darah**), Rasio Kasus **KEK** (Kurang Energi Kronis), Kasus Ibu dengan **Faktor Risiko Umur/Tinggi** hingga angka **Anemia**.
  * Semua insight data siap disortir dan **Diekspor ke Format standar dinas (PDF dan Excel `.xls`)**.

---

## 🔁 Flow Pemanfaatan Utama Aplikasi

1. **Inisiasi Kredensial Pasien:**
   * Di tingkat faskes primer tingkat pertama, *Super Admin* dan Sistem merestui Ortu mempunyai akun lewat jalur login atau via fitur tambah manual Bidan. Setelah terkoneksi dengan Profil Rekam Medis (IKD Dasar) seperti detail BPJS & NIK lengkap, aktivitas dapat ditandai *Aktif*.
2. **Kunjungan Berkala & Deteksi Dini Klinis:**
   * Tiap lawatan, Bidan menambahkan row modul "Pemeriksaan ANC" pada pasien. Pasien juga memvisualisasikannya di _Dashboard_-nya.
   * Modul e-Mail pintar siap disalurkan misal: _"Kirim Reminder"_ agar bulan depan ibu tak absen kontrol. _"Kirim Rekap"_ agar Ibu menyimpan dokumen salinannya di kotak masuk email pribadinya tanpa khawatir hilang.
3. **Mekanisme Uji Lab & Rujukan Lanjut (Triple Eliminasi):**
   * Jika hasil form skrining awal mengisyaratkan perlunya laboratorium (untuk Sifilis, Hepatitis B, HIV, GolDar, Protein Urine dsb.), pemeriksaan ini masuk di log *Draft*. Bidan mengunduh **Surat Pengantar Lab Fisik (PDF)**, diberikan ke Pasien, jika spesimen keluar nilai, form lalu bisa di *Selesai*-kan. Angka berisiko dari Form otomatis diteruskan menjadi *Rujukan Tinggi* ke Rumah Sakit.
4. **Agregasi, Konsolidasi, & Export Terpusat Dinkes:**
   * Secara berkala, kondisi *stunting* (Anemia/KEK) dikalkulasikan algoritma sistem berdasarkan rumus seperti `LILA < 23,5 cm`, `Lab HB < 11`. Data dipisahkan pada tabel metrik agregasi khusus untuk dilihat di Panel Dashboard Dinkes. Dinkes lalu bisa menarik laporan komprehensif dalam wujud Sheet/Excel untuk bahan rapat pimpinan.

---

## 🚀 Panduan Instalasi & Menjalankan Mode Development Lokal

Langkah untuk pengelola/developer IT jika berencana modifikasi / pengembangan lebih lanjut (Setup *Environment* Lokal):

### 1. Prerequisite Basis Sistem
* **PHP** veri `8.3` atau lebih baru.
* **Composer** (PHP modern Dependency Manager).
* **Node.js** dan **npm** terpasang secara _global environment_.

### 2. Langkah Detail Menjalankan
1. **Clone/Unduh repositori proyek ini**
   ```bash
   git clone <url-repository-anda>
   cd TUGAS-AKHIR-IbuHamil
   ```
2. **Instalasi Modul / Paket *Vendor* Backend & *Node_Modules* Frontend**
   ```bash
   composer install
   npm install
   ```
3. **Konfigurasi Environment Variable**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   > **Note Database (Opsional):** Jika Anda menggunakan sistem *starter* default dari kami cukup jalankan langkah nomor empat. Laravel 11/13 menggunakan parameter standar SQLite Database `.sqlite`.
4. **Migrasi *Schema* Tabel Database (Beserta injeksi set data / Dummy-Seed awal)**
   ```bash
   touch database/database.sqlite
   php artisan migrate:fresh --seed
   ```
5. **Set-Up Symlink Ruang Folder Media/Gambar & Report PDF**
   ```bash
   php artisan storage:link
   ```
6. **Jalankan Aplikasi dengan Modul Cerdas `concurrently` (Vite, Server, Queue Listiner)**
   Aplikasi menanamkan format script di `composer.json` yg bernama `dev`. Ia mengeksekusi tiga proses: Server lokal di port 8000, Vite JS bundler (Auto-reload Frontend), lalu antrian layanan e-Mail asinkronus (Queue Pekerja Latar belakang) cukup dengan satu baris mantap:
   ```bash
   npm run dev
   ```
   > Kemudian Buka laman di panel mesin peramban Anda melalui rute lokal: `http://localhost:8000` atau `http://127.0.0.1:8000`

---

## 🧪 Testing

Aplikasi mengedepankan kualitas stabil menggunakan framework masa kini **Pest PHP** (Sintaks pengganti PHPUnit dengan model struktur BDD/Behaviour-Driven yang mudah dibaca). Pengujian mencakup alur Role-based, Model kalkulasi, hingga Form Submission (*Feature Tests & Unit Tests*). 

Jalankan *Test suite* cukup via perintah CLI berikut:
```bash
php artisan test
```

> **Email Auth**: Fitur "_Forgot Password / Reset Kata Sandi_" juga sudah terpasang native dari framework di controller autentikasi via library pengiriman yang aman dengan _support Queue Background Jobs_ default di Mailpit/Mailtrap.
