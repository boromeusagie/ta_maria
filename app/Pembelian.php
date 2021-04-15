<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Pembelian as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembelian extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal', 'noFaktur', 'namaSupplier', 'kodeBarang', 'qty', 'satuan'
    ];

    protected $table = 'pembelian';
}
