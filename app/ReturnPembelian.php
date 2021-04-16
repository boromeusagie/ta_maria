<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\ReturnPembelian as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ReturnPembelian extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal', 'noReturn','noFaktur', 'kodeSupplier'
    ];

    protected $table = 'return_pembelian';

    public function items()
    {
        return $this->hasMany('App\ItemReturnPembelian', 'noReturn', 'noReturn');
    }

    public function itemPembelian()
    {
        return $this->hasMany('App\ItemPembelian', 'noFaktur', 'noFaktur');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'kodeSupplier', 'kodeSupplier');
    }
}
