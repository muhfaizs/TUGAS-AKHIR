<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Akseptor</th>
            <th>No JKN</th>
            <th>Metode KB</th>
            <th>Tujuan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($akseptors as $index => $kb)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $kb->name }}</td>
            <td>{{ $kb->no_jkn ?? '-' }}</td>
            <td>{{ $kb->metode_kb ?? '-' }}</td>
            <td>{{ $kb->tujuan ?? '-' }}</td>
            <td>{{ $kb->status == 'active' ? 'Aktif' : $kb->status }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Belum ada data akseptor KB</td>
        </tr>
        @endforelse
    </tbody>
</table>
