<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KBService;

class NotificationController extends Controller
{
    public function index()
    {
        // Temukan pelayanan yang tanggal kembalinya (follow up) sudah dekat atau terlewat
        // (contoh: 7 hari ke depan atau sudah lewat)
        $today = now();
        $nextWeek = now()->addDays(7);

        $notifications = KBService::with('acceptor')
            ->whereBetween('follow_up_date', [$today->copy()->subDays(30), $nextWeek])
            ->where('is_verified', false) // asumsi jika berlum diverifikasi artinya belum ditindaklanjuti
            ->orderBy('follow_up_date', 'asc')
            ->get();

        return view('notifications.index', compact('notifications', 'today'));
    }
}

