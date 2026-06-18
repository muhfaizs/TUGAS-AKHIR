@extends('layouts.dashboard')

@section('title', 'Imunisasi Anak')
@section('page_title', 'Data Imunisasi Anak')
@section('page_subtitle', 'Kelola riwayat pemberian vaksin dan imunisasi anak')

@section('content')
<div class="tindakan-header">
    <a href="{{ route('bidan.imunisasi.create') }}" class="btn-add">
        <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
        Tambah Imunisasi
    </a>
</div>

<div class="tindakan-card">
    <div class="table-responsive">
        <table class="tindakan-table">
            <thead>
                <tr>
                    <th>Tanggal Pemberian</th>
                    <th>Nama Anak</th>
                    <th>Nama Vaksin</th>
                    <th>Bidan Pelaksana</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($imunisasi as $i)
                <tr>
                    <td>
                        <div class="font-medium text-slate-800">{{ $i->tanggal_pemberian->format('d M Y') }}</div>
                    </td>
                    <td>
                        <div class="font-medium text-slate-800">{{ $i->anak->nama_anak ?? '-' }}</div>
                        <div class="text-xs text-slate-500">NIK: {{ $i->anak->nik_anak ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="font-medium" style="color: var(--kia-primary);">{{ $i->nama_vaksin }}</div>
                    </td>
                    <td>
                        <div class="text-sm text-slate-600">{{ $i->bidan->name ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('bidan.imunisasi.edit', $i) }}" class="btn-icon btn-icon-edit" title="Edit">
                                <svg viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                            </a>
                            <a href="{{ route('bidan.imunisasi.pdf', $i) }}" class="btn-icon" style="color: #6366F1;" title="Cetak/Download PDF" onmouseover="this.style.background='rgba(99,102,241,0.1)';" onmouseout="this.style.background='none';">
                                <svg viewBox="0 0 24 24"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                            </a>
                            @if(($i->anak && $i->anak->nomor_kontak_darurat) || ($i->anak && $i->anak->orangTua && $i->anak->orangTua->phone))
                            <form method="POST" action="{{ route('bidan.anak.send-notification', $i->anak->id_anak) }}" class="inline-form" target="_blank">
                                @csrf
                                <button type="submit" class="btn-icon" style="color: #16A34A;" title="Kirim Hasil via WhatsApp" onmouseover="this.style.background='rgba(34,197,94,0.1)';" onmouseout="this.style.background='none';">
                                    <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('bidan.imunisasi.destroy', $i) }}" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus data imunisasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-icon-delete" title="Hapus">
                                    <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8">
                        <div class="empty-state">
                            <svg class="empty-icon" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"/></svg>
                            <p class="text-slate-500 mt-2">Belum ada data imunisasi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.tindakan-header { display: flex; justify-content: flex-end; margin-bottom: 24px; }
.btn-add {
    display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px;
    background: var(--kia-primary); color: #fff; border-radius: 12px;
    font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s;
}
.btn-add:hover { background: var(--kia-primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,148,136,0.2); }
.btn-add svg { width: 18px; height: 18px; fill: currentColor; }

.tindakan-card {
    background: #fff; border-radius: 20px; padding: 24px;
    box-shadow: 0 4px 20px rgba(13,148,136,0.06); border: 1px solid rgba(15,23,42,0.06);
}

.table-responsive { overflow-x: auto; }
.tindakan-table { width: 100%; border-collapse: collapse; min-width: 600px; }
.tindakan-table th {
    text-align: left; padding: 16px; font-size: 13px; font-weight: 600;
    color: #64748B; border-bottom: 2px solid #F1F5F9; white-space: nowrap;
}
.tindakan-table td { padding: 16px; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
.tindakan-table tr:last-child td { border-bottom: none; }
.tindakan-table tbody tr:hover { background: #F8FAFC; }

.action-buttons { display: flex; gap: 8px; }
.btn-icon {
    width: 32px; height: 32px; border-radius: 8px; border: none; background: none; cursor: pointer;
    display: grid; place-items: center; transition: all 0.2s; color: #94A3B8; text-decoration: none;
}
.btn-icon-edit:hover { background: rgba(14,165,233,0.1); color: #0284C7; }
.btn-icon-delete:hover { background: rgba(239,68,68,0.1); color: #DC2626; }
.btn-icon svg { width: 16px; height: 16px; fill: currentColor; }
.inline-form { margin: 0; }

.empty-state { display: flex; flex-direction: column; align-items: center; padding: 32px 0; }
.empty-icon { width: 48px; height: 48px; fill: #CBD5E1; }
</style>
@endsection
