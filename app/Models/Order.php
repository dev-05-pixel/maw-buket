<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'product_id',
        'product_name',
        'product_price',
        'variant',
        'color',
        'customer_phone',
        'status',
        'pickup_date',
    ];

    protected $casts = [
        'product_price' => 'integer',
        'pickup_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {

            if (!$order->id) {
                $order->id = strtoupper(Str::random(12));
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'id'
        );
    }

    public function canChangeTo($newStatus)
    {
        return $this->status !== $newStatus;
    }
}
