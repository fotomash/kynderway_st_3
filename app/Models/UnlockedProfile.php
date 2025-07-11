<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnlockedProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function nanny()
    {
        return $this->belongsTo(User::class, 'nanny_id');
    }
}
