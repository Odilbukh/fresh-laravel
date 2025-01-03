<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $table = 'projects';

    protected $guarded = [
        'id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}
