# Dokumentasi Free API untuk KB Data

## Opsi 1: Random User API (RECOMMENDED) ✅

**URL:** https://randomuser.me/api/

**Deskripsi:** API untuk mendapatkan data user acak dengan data demografi lengkap

**Kelebihan:**
- Gratis dan tanpa autentikasi
- Data lengkap (nama, usia, alamat, foto)
- Respons cepat
- Bisa request multiple users sekaligus
- Geografis bisa di-filter (nat=id untuk Indonesia)

**Contoh Request:**
```bash
curl "https://randomuser.me/api/?results=15&nat=id"
```

**Response Sample:**
```json
{
  "results": [
    {
      "name": {
        "first": "Emma",
        "last": "Johnson"
      },
      "email": "emma.johnson@example.com",
      "phone": "123-456-7890"
    }
  ]
}
```

**Implementasi di Aplikasi:**
```bash
php artisan kb:fetch-data randomuser
```

---

## Opsi 2: WHO Global Health Observable API

**URL:** https://gateway.who.int/GHO/api/

**Deskripsi:** API kesehatan global dari World Health Organization

**Kelebihan:**
- Data kesehatan resmi dari WHO
- Akurat dan terpercaya
- Dokumentasi lengkap

**Kelemahan:**
- Data agregat (bukan individu)
- Respon lebih lambat
- Format data kompleks

**Implementasi:**
```bash
php artisan kb:fetch-data who
```

---

## Opsi 3: Indonesia Health API (Kawal COVID-19)

**URL:** https://api.kawal-covid19.info/

**Deskripsi:** API data kesehatan Indonesia (COVID-19, namun data publik)

**Kelebihan:**
- Data Indonesia
- Gratis dan tanpa autentikasi
- Data real-time

**Implementasi:**
```bash
php artisan kb:fetch-data indonesia
```

---

## Opsi 4: Multi-Source (Recommended)

Kombinasi dari beberapa API untuk data yang lebih kaya dan akurat.

**Implementasi:**
```bash
php artisan kb:fetch-data multiple
```

---

## Setup Instructions

### 1. Update Controller untuk menggunakan API

Edit `app/Http/Controllers/DashboardController.php`:

```php
public function __construct(KBDataService $kbDataService)
{
    $this->kbDataService = $kbDataService;
}

public function refreshData()
{
    $result = $this->kbDataService->fetchFromMultipleSources();
    return response()->json($result);
}
```

### 2. Buat Route untuk Refresh Data

Di `routes/web.php`:
```php
Route::post('/api/kb/refresh', [DashboardController::class, 'refreshData']);
```

### 3. Jalankan Command untuk Fetch Data

```bash
# Fetch dari Random User API
php artisan kb:fetch-data randomuser

# Fetch dari multiple sources
php artisan kb:fetch-data multiple

# Atau jalankan seeder biasa
php artisan db:seed
```

### 4. Setup Scheduled Task (Optional)

Di `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Refresh data setiap 1 jam
    $schedule->command('kb:fetch-data multiple')
        ->hourly()
        ->appendOutputTo(storage_path('logs/kb-fetch.log'));
}
```

Kemudian jalankan:
```bash
php artisan schedule:run
```

---

## Free APIs Lainnya yang Bisa Digunakan

| API | URL | Deskripsi | Gratis |
|-----|-----|-----------|--------|
| **Random User** | randomuser.me | Data user acak | ✅ |
| **JSONPlaceholder** | jsonplaceholder.typicode.com | Dummy data | ✅ |
| **Faker API** | fakerapi.it | Generate fake data | ✅ |
| **Open Library** | openlibrary.org/api | Data buku | ✅ |
| **Pokémon API** | pokeapi.co | Data pokemon | ✅ |
| **REST Countries** | restcountries.com | Data negara | ✅ |
| **WHO API** | gateway.who.int | Data kesehatan | ✅ |
| **Open Health** | healthinedata.com | Data kesehatan | Partial |
| **Google Maps API** | maps.googleapis.com | Maps & Lokasi | Gratis dengan batas |

---

## Contoh Integration dengan Frontend

### Tombol Refresh di Dashboard

Edit `resources/views/dashboard/index.blade.php`:

```html
<!-- Add to header -->
<button id="refreshBtn" class="px-4 py-2 bg-teal-500 text-white rounded">
    🔄 Refresh Data
</button>

<script>
document.getElementById('refreshBtn').addEventListener('click', async function() {
    const response = await fetch('/api/kb/refresh', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
    const data = await response.json();
    if (data.success) {
        location.reload(); // Reload dashboard
    }
});
</script>
```

---

## Troubleshooting

### Timeout Error
Jika mendapat timeout, tingkatkan timeout di `KBDataService`:
```php
Http::timeout(30) // Ubah dari 10 ke 30 detik
```

### CORS Error
Jika ada CORS error, pastikan API yang digunakan support CORS atau gunakan proxy server.

### Rate Limiting
Beberapa API memiliki rate limit. Check dokumentasi masing-masing API.

---

## Rekomendasi Terbaik

Untuk project ini, saya merekomendasikan **Option 4 (Multi-Source)** karena:

1. ✅ Data lebih variasi dan realistis
2. ✅ Gratis dan tanpa autentikasi
3. ✅ Mudah di-implement
4. ✅ Bisa di-schedule otomatis
5. ✅ Data terus update dengan fetch terbaru

Jalankan sekarang:
```bash
php artisan kb:fetch-data multiple
```

Dan dashboard akan menampilkan data terbaru dari API! 🎉
