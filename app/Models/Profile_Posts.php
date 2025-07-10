<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile_Posts extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'profile_posts';

    protected $guarded = [];

    public function userdetails()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function profilecat()
    {
        return $this->belongsTo(Profile_Categories::class, 'profile_category_id');
    }

    public function assigned()
    {
        return $this->belongsto(User::class, 'assigned_user_id', 'id')->latest();
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'profile_post_id', 'id');
    }

    public function activeReports()
    {
        return $this->hasMany(Report::class, 'profile_post_id', 'id')->where('status', 1);
    }
}
