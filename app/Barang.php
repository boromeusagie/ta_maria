<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    public function itemPembelian()
    {
        return $this->hasMany('App\ItemPembelian', 'kodeBarang', 'kodeBarang');
    }

    public function itemPenjualan()
    {
        return $this->hasMany('App\ItemPenjualan', 'kodeBarang', 'kodeBarang');
    }
}
