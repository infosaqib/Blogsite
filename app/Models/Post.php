<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $guarded = ['image'];
    protected $fillable = ['user_id', 'title', 'description', 'image'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
