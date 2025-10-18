<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Coupon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'coupon_code',
        'discount_amount',
        'subtotal',
        'total',
        'status',
        'shipping_address',
        'phone',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
