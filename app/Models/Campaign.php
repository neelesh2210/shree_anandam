<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'image',
        'total_raise_amount',
        'total_raised_amount',
        'short_description',
        'description',
        'is_active',
    ];
}
