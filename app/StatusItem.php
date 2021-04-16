<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusItem extends Model
{
    public $table = 'status_items';

    public function item()
    {
        return $this->belongsTo('App\ItemPembelian', 'noItemPembelian', 'noItemPembelian');
    }
}
