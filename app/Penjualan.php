<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Penjualan as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Penjualan extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal', 'noPenjualan', 'kodeBarang', 'namaBarang', 'qty', 'satuan', 'harga', 'totalHarga', 'totalBayar', 'disc', 'totalPembayaran', 'kembalian'
    ];

    protected $table = 'penjualan';
}
