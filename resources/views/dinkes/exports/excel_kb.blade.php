<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Akseptor</th>
            <th>NIK</th>
            <th>Metode KB</th>
            <th>Kunjungan Terakhir</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($akseptors as $index => $kb)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $kb->full_name ?? '-' }}</td>
            <td>{{ $kb->nik ?? '-' }}</td>
            <td>{{ $kb->lastService()->service_method ?? '-' }}</td>
            <td>{{ $kb->lastService() && $kb->lastService()->service_date ? \Carbon\Carbon::parse($kb->lastService()->service_date)->translatedFormat('d M Y') : '-' }}</td>
            <td>{{ strtolower($kb->status) == 'active' || strtolower($kb->status) == 'aktif' ? 'Aktif' : $kb->status }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Belum ada data akseptor KB</td>
        </tr>
        @endforelse
    </tbody>
</table>
