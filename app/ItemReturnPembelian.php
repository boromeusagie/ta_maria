<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemReturnPembelian extends Model
{
    protected $table = 'item_return_pembelian';

    protected $fillable = ['noItemPembelian', 'kodeBarang', 'qty', 'totalHarga'];

    public function returnPembelian()
    {
        return $this->belongsTo('App\returnPembelian', 'noReturn', 'noReturn');
    }

    public function pembelian()
    {
        return $this->belongsTo('App\pembelian', 'noFaktur', 'noFaktur');
    }

    public function barang()
    {
        return $this->belongsTo('App\Barang', 'kodeBarang', 'kodeBarang');
    }

    public function itemPembelian()
    {
        return $this->belongsTo('App\ItemPembelian', 'noItemPembelian', 'noItemPembelian');
    }
}
