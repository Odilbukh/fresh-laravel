<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = [
        'id'
    ];
    public function users(): BelongsToMany{
        return $this->belongsToMany(User::class, 'product_user');
    }
}
