<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Anak</th>
            <th>NIK</th>
            <th>Posyandu</th>
            <th>Pelaksana</th>
            <th>Berat Badan (kg)</th>
            <th>Tinggi Badan (cm)</th>
            <th>Status Gizi</th>
            <th>Status Stunting</th>
            <th>Vaksin</th>
            <th>Tindakan Medis</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporan as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $data->anak->nama_anak ?? '-' }}</td>
                <td>{{ $data->anak->nik_anak ?? '-' }}</td>
                <td>{{ $data->posyandu }}</td>
                <td>{{ count($data->pelaksana) > 0 ? implode(', ', $data->pelaksana) : '-' }}</td>
                <td>{{ $data->pengukuran ? $data->pengukuran->berat_badan : '-' }}</td>
                <td>{{ $data->pengukuran ? $data->pengukuran->tinggi_badan : '-' }}</td>
                <td>{{ $data->pengukuran ? $data->pengukuran->status_gizi : '-' }}</td>
                <td>{{ $data->pengukuran ? $data->pengukuran->status_stunting : '-' }}</td>
                <td>{{ $data->imunisasi ? $data->imunisasi->nama_vaksin : '-' }}</td>
                <td>{{ $data->tindakan ? $data->tindakan->diagnosa : '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="12">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
