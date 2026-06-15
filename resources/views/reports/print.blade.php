<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - SatuKIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .print-table { width: 100%; border-collapse: collapse; }
            .print-table th, .print-table td { border: 1px solid #000; padding: 8px; font-size: 12px; }
            .print-table th { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-10 shadow-lg rounded-lg print:shadow-none min-h-[A4]">
        <div class="flex justify-between items-center mb-8 border-b-2 border-gray-800 pb-4">
            <div class="flex items-center space-x-4">
                <div class="bg-teal-600 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-xl no-print">
                    KIA
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 uppercase">SATUKIA</h1>
                    <p class="text-xs font-bold text-gray-600">SISTEM INFORMASI PELAYANAN KELUARGA BERENCANA</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-lg font-bold">LAPORAN PELAYANAN KB</h2>
                <p class="text-sm text-gray-600">
                    Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                </p>
            </div>
        </div>

        <div class="mb-4 no-print text-right">
            <button onclick="window.print()" class="bg-teal-600 text-white px-4 py-2 rounded shadow hover:bg-teal-700 font-bold">
                🖨️ Cetak Dokumen
            </button>
        </div>

        <table class="w-full print-table border-collapse border border-gray-300">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Akseptor</th>
                    <th class="border border-gray-300 px-4 py-2">Metode KB</th>
                    <th class="border border-gray-300 px-4 py-2">Tensi / BB</th>
                    <th class="border border-gray-300 px-4 py-2">Tgl Kembali</th>
                    <th class="border border-gray-300 px-4 py-2">Bidan / Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $index => $row)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $row->created_at->format('d/m/Y') }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $row->acceptor->name ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $row->service_method }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $row->blood_pressure ?? '-' }} / {{ $row->weight ? $row->weight . ' kg' : '-' }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $row->follow_up_date ? \Carbon\Carbon::parse($row->follow_up_date)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">{{ $row->bidan->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500 border border-gray-300">Tidak ada data pelayanan pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-16 flex justify-end">
            <div class="text-center">
                <p class="mb-16 text-sm">Dicetak tanggal: {{ date('d/m/Y') }}</p>
                <p class="font-bold border-b border-gray-800 inline-block px-4">
                    {{ auth()->user()->name ?? 'Petugas KIA' }}
                </p>
                <p class="text-xs text-gray-600 mt-1 uppercase">{{ auth()->user()->role ?? 'Petugas' }}</p>
            </div>
        </div>
    </div>
</body>
</html>
