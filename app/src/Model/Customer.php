<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    public function transactions()
    {
    	return $this->hasMany('App\Model\Transaction');
    }
}
