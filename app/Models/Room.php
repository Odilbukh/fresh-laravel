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
}
