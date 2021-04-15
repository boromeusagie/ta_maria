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
}
