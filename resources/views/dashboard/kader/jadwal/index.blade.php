@extends('layouts.dashboard')

@section('title', 'Kelola Jadwal Posyandu')
@section('page_title', 'Jadwal Posyandu')
@section('page_subtitle', 'Kelola jadwal kegiatan Posyandu Anda')

@section('content')
<div class="content-header" style="display: flex; justify-content: flex-end; margin-bottom: 24px;">
    <a href="{{ route('kader.jadwal.create') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #0D9488; color: #fff; border-radius: 12px; font-weight: 600; text-decoration: none;">
        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Tambah Jadwal
    </a>
</div>

<div style="background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #F8FAFC;">
                <tr>
                    <th style="padding: 16px 24px; font-size: 13px; font-weight: 600; color: #64748B; text-transform: uppercase;">Tanggal</th>
                    <th style="padding: 16px 24px; font-size: 13px; font-weight: 600; color: #64748B; text-transform: uppercase;">Waktu</th>
                    <th style="padding: 16px 24px; font-size: 13px; font-weight: 600; color: #64748B; text-transform: uppercase;">Lokasi</th>
                    <th style="padding: 16px 24px; font-size: 13px; font-weight: 600; color: #64748B; text-transform: uppercase;">Keterangan</th>
                    <th style="padding: 16px 24px; font-size: 13px; font-weight: 600; color: #64748B; text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr style="border-bottom: 1px solid #F1F5F9;">
                        <td style="padding: 16px 24px; font-size: 14px; font-weight: 500; color: #0F172A;">
                            {{ $jadwal->tanggal->format('d M Y') }}
                            @if($jadwal->tanggal->isToday())
                                <span style="margin-left: 8px; padding: 2px 8px; background: #FEF3C7; color: #D97706; border-radius: 12px; font-size: 11px; font-weight: 600;">Hari Ini</span>
                            @endif
                        </td>
                        <td style="padding: 16px 24px; font-size: 14px; color: #475569;">
                            {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }} WIB
                        </td>
                        <td style="padding: 16px 24px; font-size: 14px; color: #475569;">
                            {{ $jadwal->lokasi }}
                        </td>
                        <td style="padding: 16px 24px; font-size: 14px; color: #64748B;">
                            {{ $jadwal->keterangan ?: '-' }}
                        </td>
                        <td style="padding: 16px 24px; display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('kader.jadwal.edit', $jadwal->id_jadwal) }}" style="padding: 8px; background: #EFF6FF; color: #3B82F6; border-radius: 8px; transition: all 0.2s;" title="Edit">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                            </a>
                            <form action="{{ route('kader.jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding: 8px; background: #FEF2F2; color: #EF4444; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" title="Hapus">
                                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #64748B;">
                            <div style="width: 64px; height: 64px; background: #F1F5F9; border-radius: 50%; display: grid; place-items: center; margin: 0 auto 16px;">
                                <svg viewBox="0 0 24 24" style="width: 32px; height: 32px; fill: #94A3B8;"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM9 14H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2zm-8 4H7v-2h2v2zm4 0h-2v-2h2v2zm4 0h-2v-2h2v2z"/></svg>
                            </div>
                            <p style="margin: 0; font-size: 15px;">Belum ada jadwal Posyandu yang dibuat.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($jadwals->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid #E2E8F0;">
            {{ $jadwals->links() }}
        </div>
    @endif
</div>
@endsection
