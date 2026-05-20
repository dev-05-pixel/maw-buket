<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'location',
        'rating',
        'message',
        'avatar_letter',
        'ip_address',
    ];

    protected $keyType = 'string';

    public $incrementing = false;
}
