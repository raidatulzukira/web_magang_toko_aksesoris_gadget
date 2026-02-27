<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Command bawaan Laravel (biarkan saja)
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ----------------------------------------------------------------
// JADWAL TUGAS OTOMATIS (SCHEDULER)
// ----------------------------------------------------------------

// Jalankan perintah 'orders:cancel-unpaid' setiap satu jam sekali.
// Perintah ini akan mengecek database, apakah ada pesanan yang 'unpaid'
// dan sudah lewat 24 jam. Jika ada, statusnya diubah jadi 'cancelled'.
// Schedule::command('orders:cancel-unpaid')->hourly();
Schedule::command('orders:cancel-unpaid')->everyMinute();
