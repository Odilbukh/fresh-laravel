<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'address',
        'description',
        'contact_info'
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'hotel_user');
    }
    public function rooms(): HasMany{
        return $this->hasMany(Room::class);
    }
}
