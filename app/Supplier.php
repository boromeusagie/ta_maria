<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Supplier as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Supplier extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'namaSupplier', 'almtSupplier', 'tlpSupplier',
    ];

    protected $table = 'supplier';

    public function pembelian()
    {
        return $this->hasMany('App\Pembelian', 'kodeSupplier', 'kodeSupplier');
    }
}
