<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable =[
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
