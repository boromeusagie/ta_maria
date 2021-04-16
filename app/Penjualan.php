<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Penjualan as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Penjualan extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tanggal', 'noFaktur'
    ];

    protected $table = 'penjualan';

    public function items()
    {
        return $this->hasMany('App\ItemPenjualan', 'noPenjualan', 'noPenjualan');
    }
}
