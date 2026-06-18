@extends('layouts.dashboard')

@section('title', 'Laporan KB')
@section('page_title', 'Laporan KB')
@section('page_subtitle', 'Rekapitulasi Pelayanan Keluarga Berencana (KB)')

@section('content')
<div class="card p-6 border-0 shadow-sm rounded-xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Tabel Rekapitulasi KB</h3>
            <p class="text-sm text-slate-500 mt-1">Data agregat jumlah akseptor KB baru dan aktif per metode kontrasepsi.</p>
        </div>
        
        <div class="flex flex-wrap gap-2">
            <form action="{{ route('kb-acceptors.laporan-r1') }}" method="GET" class="flex gap-2">
                <select name="bulan" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block px-3 py-2" onchange="this.form.submit()">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ sprintf('%02d', $i) }}" {{ request('bulan', date('m')) == sprintf('%02d', $i) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                
                <select name="tahun" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block px-3 py-2" onchange="this.form.submit()">
                    @php $currentYear = date('Y'); @endphp
                    @for($i = $currentYear; $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-lg transition-colors flex items-center gap-2">
                    <svg viewBox="0 0 24 24" class="w-4 h-4 fill-current"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                    Cetak
                </button>
            </form>
            
            <form action="{{ route('kb-acceptors.laporan-r1.submit') }}" method="POST" class="inline-block ml-2">
                @csrf
                <input type="hidden" name="bulan" value="{{ request('bulan', date('m')) }}">
                <input type="hidden" name="tahun" value="{{ request('tahun', date('Y')) }}">
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengirim laporan KB ini ke Dinas Kesehatan?')" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg transition-colors flex items-center gap-2">
                    <svg viewBox="0 0 24 24" class="w-4 h-4 fill-current"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                    Submit ke Dinkes
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-center text-sm text-slate-600 border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 uppercase text-xs font-bold border-b border-slate-200">
                <tr>
                    <th scope="col" rowspan="2" class="px-6 py-4 border-r border-slate-200 align-middle">Metode Kontrasepsi</th>
                    <th scope="col" colspan="2" class="px-6 py-3 border-b border-slate-200">Jumlah Peserta KB</th>
                </tr>
                <tr>
                    <th scope="col" class="px-6 py-3 border-r border-slate-200">Baru (Bulan Ini)</th>
                    <th scope="col" class="px-6 py-3">Aktif (Total)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($laporanData as $data)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-800 border-r border-slate-200 text-left">
                            {{ $data['metode'] }}
                        </td>
                        <td class="px-6 py-4 border-r border-slate-200">
                            {{ $data['baru'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $data['aktif'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50 font-bold text-slate-800">
                <tr>
                    <td class="px-6 py-4 border-r border-slate-200 text-right">TOTAL</td>
                    <td class="px-6 py-4 border-r border-slate-200">{{ $totalBaru }}</td>
                    <td class="px-6 py-4">{{ $totalAktif }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Tabel Rincian Detail Pelayanan Pasien -->
    <div class="mt-12">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Daftar Rincian Pelayanan Pasien</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 border border-slate-200">
                <thead class="bg-slate-100 text-slate-700 uppercase text-xs font-bold border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 border-r border-slate-200">No</th>
                        <th class="px-4 py-3 border-r border-slate-200">Nama Akseptor</th>
                        <th class="px-4 py-3 border-r border-slate-200">Metode</th>
                        <th class="px-4 py-3 border-r border-slate-200">Tgl Pelayanan</th>
                        <th class="px-4 py-3 border-r border-slate-200">Lokasi</th>
                        <th class="px-4 py-3 border-r border-slate-200">Risiko / Efek Samping</th>
                        <th class="px-4 py-3">Kontraindikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($detailLayanan as $index => $layanan)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 border-r border-slate-200">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 border-r border-slate-200">
                                <div class="font-semibold">{{ $layanan->acceptor->full_name }}</div>
                                <div class="text-xs text-slate-500">{{ $layanan->acceptor->nik }}</div>
                            </td>
                            <td class="px-4 py-3 border-r border-slate-200">{{ $layanan->service_method }}</td>
                            <td class="px-4 py-3 border-r border-slate-200">{{ \Carbon\Carbon::parse($layanan->service_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 border-r border-slate-200 capitalize">{{ $layanan->location }}</td>
                            <td class="px-4 py-3 border-r border-slate-200 text-xs">{{ $layanan->side_effects ?: '-' }}</td>
                            <td class="px-4 py-3 text-xs">{{ $layanan->contraindication ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada data pelayanan di bulan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-2 gap-4 text-sm print-only-section">
        <div class="text-center">
            <p>Mengetahui,</p>
            <p class="mb-16">Kepala Puskesmas</p>
            <p class="font-bold underline">_________________________</p>
            <p>NIP.</p>
        </div>
        <div class="text-center">
            <p>Tempat, {{ date('d F Y') }}</p>
            <p class="mb-16">Bidan Koordinator</p>
            <p class="font-bold underline">{{ auth()->user()->nama_lengkap }}</p>
            <p>NIP. {{ auth()->user()->nip ?? '-' }}</p>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card * {
            visibility: visible;
        }
        .card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none !important;
        }
        .flex-wrap {
            display: none !important;
        }
        .print-only-section {
            display: grid !important;
        }
    }
    @media screen {
        .print-only-section {
            display: none;
        }
    }
</style>
@endsection
