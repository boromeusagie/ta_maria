<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPenjualan extends Model
{
    protected $table = 'item_penjualan';

    protected $fillable = [ 'kodeBarang', 'qty', 'totalHarga'];

    public function penjualan()
    {
        return $this->belongsTo('App\Penjualan', 'noPenjualan', 'noPenjualan');
    }

    public function barang()
    {
        return $this->belongsTo('App\Barang', 'kodeBarang', 'kodeBarang');
    }
}
