<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = ['city_id','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
