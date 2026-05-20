<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContactMessage extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'purpose',
        'color_pref',
        'message',
        'is_read',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->getHex()->toString();
            }
        });
    }

    public function getWhatsappLinkAttribute()
    {

        $phone = preg_replace('/[^0-9]/', '', $this->phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        if (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }

        return 'https://wa.me/' . $phone;
    }
}
