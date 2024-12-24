<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function bookings(){
        return $this->BelongsTo(Booking::class);
    }
}
