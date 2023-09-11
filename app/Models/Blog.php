<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'image',
        'user_id'
    ];

    protected $casts = [
        'is_active' => 'integer', // Cast 'is_active' to boolean
    ];
    protected $attributes = [
        'is_active' => 1, // Set a default value for 'is_active'
    ];
}
