<?php

namespace App\Observers;

use App\Models\ActivityLog;

class ActivityLogObserver
{
    /**
     * Handle the ActivityLog "created" event.
     */
    public function created(ActivityLog $activityLog): void
    {
        // Batas maksimal data
        $maxLimit = 1000;

        // Cek total data sekarang
        $count = ActivityLog::count();

        // Jika melebihi batas (misal jadi 1001)
        if ($count > $maxLimit) {
            // Hitung berapa yang harus dihapus (selisihnya)
            $excess = $count - $maxLimit;

            // Hapus data yang paling tua (berdasarkan ID atau created_at)
            ActivityLog::orderBy('id', 'asc') // Urutkan dari yang paling tua (ID kecil)
                ->limit($excess)              // Ambil sejumlah kelebihannya
                ->delete();                   // Hapus
        }
    }
}