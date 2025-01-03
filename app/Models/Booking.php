<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_CONFIRMED = 'ok';
    public const STATUS_CANCEL = 'cancel';

    protected $fillable = [
        'user_id',
        'hotel_id',
        'guests',
        'total_amount',
        'check_in_date',
        'check_out_date',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_room');
    }

    public function invoices()
    {
        return $this->hasOne(Invoice::class);
    }
}
