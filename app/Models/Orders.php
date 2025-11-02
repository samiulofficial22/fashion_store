<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'user_id',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'subtotal',
        'tax',
        'total',
        'status',
    ];
      public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
