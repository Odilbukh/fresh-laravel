<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'booking_id',
        'amount',
        'status',
    ];

    public function bookings(){
        return $this->BelongsTo(Booking::class);
    }
}
