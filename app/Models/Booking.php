<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_id',
        'room_id',
        'check_in_date',
        'check_out_date',
    ];
    public function clients(){
        return $this->belongsTo(Client::class);
    }
    public function rooms(){
        return $this->belongsTo(Room::class);
    }
    public function invoices(){
        return $this->hasOne(Invoice::class);
    }
}
