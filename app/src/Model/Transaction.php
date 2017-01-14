<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer');
    }
}
