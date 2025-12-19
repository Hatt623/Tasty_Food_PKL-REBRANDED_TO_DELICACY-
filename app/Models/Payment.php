<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $fillable = ['reservation_id', 'amount', 'method', 'transaction_id', 'status'];

    //relasi dengan reservation
    public function reservation(){
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
