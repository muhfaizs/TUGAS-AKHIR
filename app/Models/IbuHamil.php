<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IbuHamil extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'hpht' => 'date',
        'hpl' => 'date',
        'tanggal_registrasi_pasien' => 'date',
        'pemeriksaan_terakhir' => 'date',
    ];

    /**
     * Get the bidan that owns the IbuHamil
     */
    public function bidan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }

    /**
     * Get the ANC examinations for the IbuHamil
     */
    public function pemeriksaanAncs()
    {
        return $this->hasMany(PemeriksaanAnc::class)->orderBy('tanggal_pemeriksaan', 'desc');
    }

    /**
     * Generate QuickChart URL for Fetal Development (TFU, DJJ, BB)
     */
    public function getQuickChartUrl()
    {
        if (! $this->pemeriksaanAncs || $this->pemeriksaanAncs->count() === 0) {
            return null;
        }

        $labels = [];
        $dataTfu = [];
        $dataDjj = [];
        $dataBb = [];

        foreach ($this->pemeriksaanAncs->sortBy('tanggal_pemeriksaan') as $anc) {
            $labels[] = $anc->tanggal_pemeriksaan->format('d M y');
            $dataTfu[] = (float) $anc->tinggi_fundus_uteri ?: 0;
            $dataDjj[] = (float) $anc->denyut_jantung_janin ?: 0;
            $dataBb[] = (float) $anc->berat_badan ?: 0;
        }

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Tinggi Fundus Uteri (cm)',
                        'data' => $dataTfu,
                        'borderColor' => '#ec4899',
                        'backgroundColor' => 'transparent',
                        'fill' => false,
                    ],
                    [
                        'label' => 'DJJ (bpm)',
                        'data' => $dataDjj,
                        'borderColor' => '#0d9488',
                        'backgroundColor' => 'transparent',
                        'fill' => false,
                    ],
                    [
                        'label' => 'Berat Badan (kg)',
                        'data' => $dataBb,
                        'borderColor' => '#eab308',
                        'backgroundColor' => 'transparent',
                        'fill' => false,
                    ],
                ],
            ],
            'options' => [
                'title' => [
                    'display' => true,
                    'text' => 'Grafik Perkembangan Janin',
                ],
            ],
        ];

        return 'https://quickchart.io/chart?w=600&h=300&c='.urlencode(json_encode($chartConfig));
    }

    /**
     * Jadwal pemeriksaan selanjutnya otomatis berdasarkan usia kehamilan
     */
    public function getJadwalSelanjutnyaAttribute()
    {
        $latestAnc = $this->pemeriksaanAncs()->orderBy('tanggal_pemeriksaan', 'desc')->first();

        if (! $latestAnc) {
            return 'Segera Periksa';
        }

        $tanggalTerakhir = $latestAnc->tanggal_pemeriksaan;
        $usiaMinggu = (int) $this->usia_kehamilan;

        if ($usiaMinggu < 28) {
            // Trimester 1 & 2: tiap 4 minggu
            return $tanggalTerakhir->copy()->addWeeks(4)->format('d M Y');
        } elseif ($usiaMinggu < 36) {
            // Trimester 3 awal: tiap 2 minggu
            return $tanggalTerakhir->copy()->addWeeks(2)->format('d M Y');
        } else {
            // Trimester 3 akhir: tiap 1 minggu
            return $tanggalTerakhir->copy()->addWeeks(1)->format('d M Y');
        }
    }
}
