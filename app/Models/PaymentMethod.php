<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'type',
        'last_four',
        'exp_month',
        'exp_year',
        'stripe_payment_method_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
