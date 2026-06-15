# DEVELOPMENT ROADMAP - SatuKIA
# Platform Monitoring Kesehatan Keluarga Berencana (KB) Indonesia

**Status:** Project Initialization Phase  
**Created:** May 19, 2026  
**Last Updated:** May 19, 2026  
**Framework:** Laravel 13 + Tailwind CSS 4 + Chart.js

---

## 📋 RINGKASAN PROJECT

**SatuKIA** adalah sistem informasi terintegrasi untuk monitoring dan manajemen pelayanan Keluarga Berencana (KB), Kesehatan Ibu Hamil (Antenatal Care), dan Kesehatan Bayi di tingkat puskesmas, kecamatan, dan dinas kesehatan.

### Tujuan Utama
- Menyediakan dashboard terpadu untuk monitoring kesehatan reproduksi
- Memfasilitasi pelaporan dan analisis data KB secara real-time
- Meningkatkan komunikasi antara berbagai stakeholder kesehatan
- Memberikan notifikasi dan rekomendasi berbasis data untuk intervensi dini

---

## 👥 ACTORS & ROLES DENGAN PERMISSIONS

### 1. **Super Admin** (Administrator Sistem)
**Deskripsi:** Mengelola seluruh sistem, user, dan konfigurasi

**Permissions:**
- ✅ Akses penuh ke semua fitur & data
- ✅ Manage semua user accounts
- ✅ Manage roles & permissions
- ✅ Konfigurasi sistem & settings
- ✅ View audit logs
- ✅ System backup & restore
- ✅ Delete/archive data

**UI Focus:** Admin Panel dengan User Management, Settings, Audit Trail

---

### 2. **Orang tua/Pasien** (End User / Patient)
**Deskripsi:** Anggota keluarga yang menerima pelayanan KB/kesehatan

**Permissions:**
- ✅ Registrasi akun mandiri
- ✅ Lengkapi & edit profil pribadi & keluarga
- ✅ Lihat riwayat pelayanan KB
- ✅ Lihat hasil pemeriksaan kehamilan
- ✅ Lihat jadwal vaksinasi & imunisasi bayi
- ✅ Download laporan/sertifikat kesehatan
- ✅ Terima notifikasi & rekomendasi
- ❌ Edit data orang lain
- ❌ Access data regional

**UI Focus:** Dashboard personal, Profile, Service History, Notifications

---

### 3. **Bidan** (Health Worker / Midwife)
**Deskripsi:** Petugas kesehatan yang memberikan layanan langsung

**Permissions:**
- ✅ Input data pelayanan KB
- ✅ Input pemeriksaan kehamilan (ANC)
- ✅ Input pemeriksaan & imunisasi bayi
- ✅ Kelola data pasien di puskesmasnya
- ✅ Lihat riwayat pelayanan per pasien
- ✅ Men-generate laporan harian/bulanan
- ✅ Buat notifikasi untuk pasien
- ✅ Input pengukuran fisik bayi
- ❌ Delete data (hanya edit & input)
- ❌ Akses data puskesmas lain

**UI Focus:** Service Input Forms, Patient Records, Daily Report, Notifications

---

### 4. **UPT KB** (Unit Pelaksana Teknis KB)
**Deskripsi:** Supervisor/Koordinator KB di puskesmas

**Permissions:**
- ✅ View semua data pelayanan KB di unit
- ✅ Approve/Verify laporan dari bidan
- ✅ Generate laporan rekapitulasi bulanan
- ✅ Monitor dashboard kesehatan puskesmas
- ✅ Lihat trend dan statistik 6 bulan
- ✅ Export data untuk laporan
- ✅ Manage kader di unit
- ✅ Assign bidan ke area tertentu
- ❌ Edit data pasien (hanya view)
- ❌ Delete approved records

**UI Focus:** Puskesmas Dashboard, Reports, Analytics, Verification Panel

---

### 5. **Kader** (Community Health Volunteer)
**Deskripsi:** Petugas kesehatan masyarakat di level desa/komunitas

**Permissions:**
- ✅ Input data KB dasar
- ✅ Monitor kesehatan keluarga di wilayah
- ✅ Rekomendasikan rujukan ke puskesmas
- ✅ Edukasi & promosi KB
- ✅ Lihat data komunitas desa
- ✅ Input pengukuran fisik bayi sederhana
- ✅ Create alerts untuk emergency cases
- ❌ Input pemeriksaan kompleks
- ❌ Lihat data dari desa lain

**UI Focus:** Simple Mobile-Friendly Interface, Community Dashboard, Alerts

---

### 6. **Dinas Kesehatan** (Health Department Officials)
**Deskripsi:** Petugas dinas kesehatan untuk monitoring regional/kabupaten

**Permissions:**
- ✅ View semua data regional/kabupaten
- ✅ Monitor & download laporan wilayah
- ✅ Analisis data kesehatan lintas puskesmas
- ✅ Generate laporan strategi dan kebijakan
- ✅ Lihat perbandingan antar puskesmas
- ✅ Generate PDF reports & rekomendasi
- ✅ Akses data real-time dashboard
- ❌ Edit data individual
- ❌ Modify user from other dinas

**UI Focus:** Regional Dashboard, Comparative Analytics, Executive Reports

---

## 🎯 FITUR-FITUR BERDASARKAN USE CASE

### FASE 1: AUTHENTICATION & USER MANAGEMENT (FOUNDATION)
**Prioritas:** 🔴 CRITICAL | **Durasi:** 2-3 minggu

#### 1.1 Registrasi Akun Mandiri
- [ ] Buat UI form registrasi (nama, email, password, role)
- [ ] Implement email verification
- [ ] Handle duplicate email
- [ ] Redirect ke profile completion setelah registrasi

**User Story:**


**Database Changes:**
```php
- Add 'role' column to users table (enum: super_admin, patient, bidan, upt_kb, kader, dinas_kesehatan)
- Add 'status' column (active, inactive, verified)
- Add 'phone' dan 'address' columns

### Mengelola data akun pengguna (admin)
GET    /admin/users              - List semua users
GET    /admin/users/{id}/edit    - Edit user form
POST   /admin/users              - Create user
PUT    /admin/users/{id}         - Update user
DELETE /admin/users/{id}         - Delete user
POST   /admin/users/import       - Bulk import

### PROFILE & DATA MANAGEMENT
Prioritas: 🔴 CRITICAL | Durasi: 3-4 minggu

2.1 Melengkapi Biodata Diri/Keluarga
 Create family tree/structure input form
 Input member keluarga (nama, DOB, NIK, hubungan keluarga)
 Photo upload for family members
 Medical history input
 Emergency contact information

Database New Tables:
<?php
CREATE TABLE families (
    id, user_id, head_of_family_id, address, village, district, 
    sub_district, postal_code, timestamps
)

CREATE TABLE family_members (
    id, family_id, name, date_of_birth, gender, nik, 
    relationship, occupation, education, health_status, timestamps
)

2.2 Mengelola Profil Keluarga & Pasien
 View profile keluarga dengan struktur pohon
 Edit member keluarga
 Archive/Delete member
 View health summary per member
UI Components:

Family tree visualization
Member card with health status
Edit profile modal

Routes:
GET    /family                        - List family members
POST   /family/members                - Add member
PUT    /family/members/{id}           - Edit member
DELETE /family/members/{id}           - Remove member
GET    /family/members/{id}/health    - View health records

FASE 3: CORE HEALTH SERVICES MANAGEMENT
Prioritas: 🔴 CRITICAL | Durasi: 4-5 minggu

3.1 Mengelola Pelayanan KB (KB Services)
Current Database: kb_services table sudah ada 

Enhancements Needed:

<?php
ALTER TABLE kb_services ADD (
    family_id, member_id,             // Link to family structure
    bidan_id,                         // Assigned bidan
    notes TEXT,                       // Medical notes
    follow_up_date DATE,              // Follow-up date
    next_method STRING,               // If method change
    acceptor_status enum,             // Additional status
    is_verified BOOLEAN,              // QC/verification flag
    verified_by,                      // Admin who verified
    verified_at TIMESTAMP
)

Features:

 Input form dengan semua method KB
 Schedule follow-up
 Track method changes
 Drop-out reason & tracking
 History/timeline view

Routes:
GET    /kb-services                   - List KB services
POST   /kb-services                   - Create new service
GET    /kb-services/{id}              - View detail
PUT    /kb-services/{id}              - Update service
DELETE /kb-services/{id}              - Archive service
GET    /kb-services/{id}/history      - View history
POST   /kb-services/{id}/verify       - Verify (admin)

Features:

 Input form dengan semua method KB
 Schedule follow-up
 Track method changes
 Drop-out reason & tracking
 History/timeline view

Routes:
GET    /kb-services                   - List KB services
POST   /kb-services                   - Create new service
GET    /kb-services/{id}              - View detail
PUT    /kb-services/{id}              - Update service
DELETE /kb-services/{id}              - Archive service
GET    /kb-services/{id}/history      - View history
POST   /kb-services/{id}/verify       - Verify (admin)

3.2 Mengelola Pemeriksaan Kehamilan/ANC
New Database Table:

