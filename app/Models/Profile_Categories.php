<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile_Categories extends Model
{
    use HasFactory;

    protected $table = 'profile_categories';

    protected $fillable = [
        'categoryname'
    ];

    public function jobs()
    {
        return $this->hasMany(Job_Posts::class);
    }
}
