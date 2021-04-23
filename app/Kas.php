<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $table = 'kas';

    public function pembelian()
    {
        return $this->hasOne('App\Pembelian', 'noKas', 'noKas');
    }

    public function penjualan()
    {
        return $this->hasOne('App\Penjualan', 'noKas', 'noKas');
    }
}
