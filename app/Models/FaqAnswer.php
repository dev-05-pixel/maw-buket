<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqAnswer extends Model
{
    protected $fillable = [
        'answer'
    ];

    public function questions()
    {
        return $this->hasMany(FaqQuestion::class, 'answer_id');
    }
}
