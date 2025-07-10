<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Getverified extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'getverified';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function assigned()
    {
        return $this->belongsto(User::class, 'assigned_user_id', 'id')->latest();
    }
}
