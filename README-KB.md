# Sistem Informasi Layanan Posyandu & Keluarga Berencana (KB)

Project ini adalah sebuah Aplikasi Sistem Informasi Kesehatan yang difokuskan pada manajemen layanan Posyandu, kesehatan anak, dan program Keluarga Berencana (KB). Dibangun dengan menggunakan kerangka kerja (framework) **Laravel**, project ini mengintegrasikan berbagai peran tenaga kesehatan dan masyarakat untuk mencatat, melacak, serta melaporkan rekam medis, tumbuh kembang anak, dan statistik keluarga berencana secara komprehensif.

## 💻 Tech Stack
- **Framework Backend**: Laravel v13.x (PHP 8.3+)
- **Frontend / Styling**: Blade Templates, TailwindCSS v4, HTML/CSS/JS via Vite
- **Database**: MySQL / MariaDB (via Eloquent ORM & Migrations)
- **PDF Generation**: barryvdh/laravel-dompdf (Untuk pembuatan laporan format PDF)
- **Testing**: PestPHP & PHPUnit

## 👥 Aktor & Hak Akses (Role)
Aplikasi ini mendukung konsep *Multi-Role* yang membatasi hak akses sesuai dengan fungsi dari masing-masing instansi atau pengguna:
1. **Pusat / Super Admin & Admin**
   - Mengelola data master (Puskesmas, Kabupaten, Master Data).
   - Mengelola akses pengguna (User Management).
2. **Kader Posyandu**
   - Membuat dan mengelola Jadwal Posyandu.
   - Melakukan entri data Pengukuran Anak (berat badan, tinggi badan, dsb).
3. **Bidan**
   - Mengelola jadwal persalinan, Tindakan Medis, dan Imunisasi anak.
   - Mengelola layanan Keluarga Berencana (Akseptor KB & Layanan KB).
   - Mengelola Follow-Up (tindak lanjut layanan KB) dan Notifikasi.
4. **Dinas Kesehatan (Dinkes)**
   - Mengakses Dashboard analitik & memantau statistik program kesehatan.
   - Melihat dan mengekspor laporan akhir per daerah/kabupaten (PDF/Excel).
5. **Orang Tua / Pasien**
   - Mendaftarkan profil anak.
   - Melihat histori Rekam Medis (tindakan, pengukuran, imunisasi) melalui Patient Portal.

## ✨ Fitur Utama
- **Patient Portal & Manajemen Anak**: Antarmuka untuk orang tua memantau rekam medis, pengukuran, dan imunisasi anak secara real-time.
- **Modul Posyandu**: Penjadwalan kegiatan posyandu dan pencatatan hasil pengukuran tumbuh kembang balita.
- **Modul Keluarga Berencana (KB)**: Pencatatan akseptor KB, layanan KB, dan *follow-up* jadwal KB selanjutnya.
- **Rekam Medis Terpadu**: Terdiri dari catatan *Tindakan Medis*, *Imunisasi*, dan *Pengukuran* balita yang direlasikan ke data setiap anak.
- **Laporan & Ekspor Dokumen**: Cetak laporan (Imunisasi, Rekam Medis Anak, Laporan Dinas Kesehatan) dengan mudah dalam berbagai format (PDF/Print layar).
- **Integrasi API**: Dilengkapi service job (`FetchKBDataFromAPI`) dan service (`KBDataService`) untuk mengambil, menyelaraskan, dan menarik data statistik dari sumber eksternal / pusat.
- **Notifikasi Push/Email**: Pengiriman pembaruan rekam medis menggunakan mail `MedicalResultMail` dan push notifikasi via dashboard.

## 🔄 Alur Kerja Sistem (Workflow)
1. **Registrasi**:
   Pasien/Orang tua mendaftar ke dalam sistem untuk mendapatkan akun, kemudian menambahkan data profil anak mereka ke platform.
2. **Perencanaan Posyandu**:
   Kader menentukan jadwal pembukaan kegiatan Posyandu (tanggal dan lokasi).
3. **Pemeriksaan & Pengukuran**:
   Di hari Posyandu, Anak melakukan pengukuran tumbuh kembang (TB/BB) yang dicatat ke sistem oleh **Kader**.
4. **Tindakan Medis & Imunisasi**:
   Apabila terdapat kebutuhan lanjutan atas kondisi medis anak atau imunisasi, **Bidan** akan memberikan tindakan dan mencatatkan data ke buku rekam medis balita tersebut di sistem. 
5. **Layanan KB**:
   Ibu / Pasien Dewasa dapat mendaftar layanan KB, **Bidan** melakukan entry *Akseptor KB* dan *Layanan KB*. Follow-up layanan dijadwalkan agar pasien bisa dipantau berkesinambungan.
6. **Notifikasi**:
   Orang tua maupun pasien akan menerima Notifikasi (melalui email / dashboard alert) apabila tindakan, pengingat kontrol, maupun jadwal posyandu telah turun.
7. **Reporting (Pelaporan)**:
   Aktivitas kesehatan ini diakumulasikan. **Dinas Kesehatan** dan **Admin** dapat melakukan cross-check secara langsung via laporan digital (Dashboard Dashboard Controller Data) maupun mengunduhnya dalam bentuk fisik administratif.

## 🚀 Cara Menjalankan Project (Local Development)
1. Pastikan Anda menginstall `PHP >= 8.3`, `Composer`, dan `Node.js`.
2. Lakukan clone repositori.
3. Salin environment env: `cp .env.example .env`
4. Jalankan perintah script full instalasi:
   ```bash
   composer run setup
   ```
   *Atau secara manual:*
   ```bash
   composer install
   npm install
   npm run build
   php artisan key:generate
   php artisan migrate --seed
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
