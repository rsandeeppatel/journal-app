<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
}
