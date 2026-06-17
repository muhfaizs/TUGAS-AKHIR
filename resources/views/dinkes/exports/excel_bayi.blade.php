<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Lokasi/Faskes Terakhir</th>
            <th>Nama Bayi</th>
            <th>NIK Bayi</th>
            <th>Nama Ibu</th>
            <th>BB/TB Terakhir</th>
            <th>Status Stunting</th>
            <th>Imunisasi & Tindakan Terakhir</th>
        </tr>
    </thead>
    <tbody>
        @forelse($anaks as $index => $anak)
        @php 
            $latest = $anak->latestPengukuran;
            $lokasiUtama = '-';
            if(isset($anak->orangTua->posyandu)) {
                $lokasiUtama = $anak->orangTua->posyandu->nama_posyandu;
            } elseif(isset($anak->orangTua->puskesmas)) {
                $lokasiUtama = $anak->orangTua->puskesmas->name ?? $anak->orangTua->puskesmas->nama_puskesmas ?? 'Puskesmas';
            } elseif($latest && isset($latest->kader->posyandu)) {
                $lokasiUtama = $latest->kader->posyandu->nama_posyandu;
            } elseif($anak->tindakanMedis->count() > 0) {
                $lastTindakan = $anak->tindakanMedis->last();
                $lokasiUtama = $lastTindakan->bidan->puskesmas->name ?? $lastTindakan->bidan->puskesmas->nama_puskesmas ?? $lastTindakan->puskesmas->name ?? $lastTindakan->puskesmas->nama_puskesmas ?? $lastTindakan->posyandu->nama_posyandu ?? 'Faskes';
            } elseif($anak->imunisasi->count() > 0) {
                $lastImun = $anak->imunisasi->last();
                $lokasiUtama = $lastImun->bidan->puskesmas->name ?? $lastImun->bidan->puskesmas->nama_puskesmas ?? $lastImun->puskesmas->name ?? $lastImun->puskesmas->nama_puskesmas ?? $lastImun->posyandu->nama_posyandu ?? 'Faskes';
            }
        @endphp
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $lokasiUtama }}</td>
            <td>{{ $anak->nama_anak }}</td>
            <td>{{ $anak->nik_anak }}</td>
            <td>{{ $anak->nama_ibu }}</td>
            <td>{{ $latest ? $latest->berat_badan.' kg / '.$latest->tinggi_badan.' cm' : '-' }}</td>
            <td>{{ $latest ? $latest->status_stunting : '-' }}</td>
            <td>
                @if($anak->imunisasi->count() > 0)
                    Imunisasi: {{ $anak->imunisasi->last()->nama_vaksin }}
                @endif
                @if($anak->tindakanMedis->count() > 0)
                    Tindakan: {{ \Illuminate\Support\Str::limit($anak->tindakanMedis->last()->diagnosa, 20) }}
                @endif
                @if($anak->imunisasi->count() == 0 && $anak->tindakanMedis->count() == 0)
                    -
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Belum ada data layanan bayi</td>
        </tr>
        @endforelse
    </tbody>
</table>
