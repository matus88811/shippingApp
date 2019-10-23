<?php

namespace App;

use App\Payment;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{

	protected $guarded = [];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

}
