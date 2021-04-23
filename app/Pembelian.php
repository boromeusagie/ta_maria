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
        'tanggal', 'noFaktur', 'kodeSupplier'
    ];

    protected $table = 'pembelian';

    public function items()
    {
        return $this->hasMany('App\ItemPembelian', 'noFaktur', 'noFaktur');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'kodeSupplier', 'kodeSupplier');
    }

    public function kas()
    {
        return $this->belongsTo('App\Kas', 'noKas', 'noKas');
    }
}
