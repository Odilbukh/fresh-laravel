<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'hotel_id',
        'type',
        'beds',
        'price_per_night',
        'description'
    ];

    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class, 'room_service');
    }

    public function bookings(){
        return $this->belongsToMany(Booking::class,'booking_room');
    }

}
