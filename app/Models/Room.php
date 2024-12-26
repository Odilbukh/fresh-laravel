<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
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
        return $this->hasMany(Booking::class);
    }

}
