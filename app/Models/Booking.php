<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }

    public function nanny()
    {
        return $this->belongsTo(User::class, 'nanny_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
