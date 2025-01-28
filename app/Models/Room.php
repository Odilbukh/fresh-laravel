<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = [
       'hotel_name',
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


    public function hotelName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->hotel?->name ?? ''
        );
    }

    public function getPriceForWeekAttribute()
    {
        return $this->price_per_night * 7;
    }
}
