<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPembelian extends Model
{
    protected $table = 'item_pembelian';

    protected $fillable = ['noItemPembelian', 'kodeBarang', 'qty', 'totalHarga'];

    public function pembelian()
    {
        return $this->belongsTo('App\Pembelian', 'noFaktur', 'noFaktur');
    }

    public function barang()
    {
        return $this->belongsTo('App\Barang', 'kodeBarang', 'kodeBarang');
    }

    public function terima()
    {
        return $this->hasOne('App\PenerimaanBarang', 'noItemPembelian', 'noItemPembelian');
    }
    public function return()
    {
        return $this->hasOne('App\ItemReturnPembelian', 'noItemPembelian', 'noItemPembelian');
    }
}
