<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    protected $table = 'penerimaan_barang';

    public function itemPembelian()
    {
        return $this->belongsTo('App\ItemPembelian', 'noItemPembelian', 'noItemPembelian');
    }
}
