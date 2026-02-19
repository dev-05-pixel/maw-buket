<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'stock',
        'sold_count',
        'description',
        'image',
        'category_id',
        'is_active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
            $model->slug = Str::slug($model->name) . '-' . substr(Str::uuid(), 0, 5);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'uid');
    }

    public function getRouteKeyName()
    {
        return 'uid';
    }
}
