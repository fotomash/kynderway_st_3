<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Language extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_language';

    protected $guarded = [];

    public function getusers()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
