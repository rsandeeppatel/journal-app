<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Role extends BaseModel
{
    use HasFactory;

    public function user(): HasOne 
    {
        return $this->hasOne(User::class);
    }
}
