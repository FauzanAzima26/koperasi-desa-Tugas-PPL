<?php

namespace App\Observers;

use App\Models\Pinjaman;
use App\Models\Transaksi;

class TransaksiObserver
{
    public function created(Transaksi $transaksi)
    {
        if ($transaksi->kategori === 'pinjaman') {
            Pinjaman::create([
                'anggota_id' => $transaksi->anggota_id,
                'transaksi_id' => $transaksi->id,
                'jumlah_pinjaman' => $transaksi->jumlah,
                'tenor_bulan' => request('tenor_bulan'),
                'status' => 'belum_lunas',
            ]);
        }
    }
}
