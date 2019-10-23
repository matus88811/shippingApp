<?php

namespace App;

use App\Bank;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

	protected $guarded = [];
	
     public function bank()
    {
        return $this->hasOne(Bank::class);
    }
}
