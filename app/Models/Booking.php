<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'hotel_id',
        'guests',
        'status',
        'total_amount',
        'check_in_date',
        'check_out_date',
    ];
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function rooms(){
        return $this->belongsTo(Room::class);
    }
    public function invoices(){
        return $this->hasOne(Invoice::class);
    }
}
