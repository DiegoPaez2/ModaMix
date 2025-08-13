<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'country',
        'billing_address',
        'city',
        'state',
        'parroquia_barrio',
        'zipcode',
        'phone',
        'order_notes',
        'payment_method',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
