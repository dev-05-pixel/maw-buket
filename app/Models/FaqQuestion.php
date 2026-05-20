<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{
    protected $fillable = [

        'answer_id',
        'question',
        'embedding'

    ];

    public function answer()
    {
        return $this->belongsTo(FaqAnswer::class, 'answer_id');
    }
}
