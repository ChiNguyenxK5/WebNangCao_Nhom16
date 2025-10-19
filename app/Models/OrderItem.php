<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'pizza_id',
        'pizza_name',
        'pizza_size',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function getSizeTextAttribute()
    {
        $sizes = [
            'small' => 'Nhỏ',
            'medium' => 'Vừa',
            'large' => 'Lớn',
        ];

        return $sizes[$this->pizza_size] ?? 'Không xác định';
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function pizza()
    {
        return $this->belongsTo(Pizza::class);
    }
}
