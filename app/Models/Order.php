<?php

namespace App\Models;

use App\Mail\OrderCompletedMail;
use App\Events\OrderStatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'total', 'country',
        'session_id', 'shipping_status', 'tracking_number', 'estimated_delivery',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($order) {
            if ($order->status === 'completed' && $order->wasChanged('status')) {
                event(new OrderStatusChanged($order));
            }
        });
        static::created(function ($order) {
            if ($order->status === 'completed' && $order->wasChanged('status')) {
                event(new OrderStatusChanged($order));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function billingDetail()
    {
        return $this->hasOne(BillingDetail::class, 'user_id', 'user_id');
    }

    public function getSubtotalAttribute()
    {
        return $this->orderItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }
}
