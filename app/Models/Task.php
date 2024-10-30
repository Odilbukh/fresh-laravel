<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Task extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'comments',
        'planned_at',
        'user_id'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
