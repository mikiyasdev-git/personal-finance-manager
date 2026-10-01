<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'currency',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
