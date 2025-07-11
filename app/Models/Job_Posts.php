<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Geocodable;

class Job_Posts extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Geocodable;

    protected $table = 'job_posts';

    protected $guarded = [];

    public function profilecategory()
    {
        return $this->belongsTo(Profile_Categories::class, 'profile_category_id');
    }

    public function userdetails()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userconnection()
    {
        return $this->hasMany(User_Connections::class, 'jobappliedid');
    }

    public function applied()
    {
        return $this->hasMany(User_Connections::class, 'jobappliedid')->withTrashed();
    }

    public function assigned()
    {
        return $this->belongsto(User::class, 'assigned_user_id', 'id')->latest();
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'job_post_id', 'id');
    }

    public function activeReports()
    {
        return $this->hasMany(Report::class, 'job_post_id', 'id')->where('status', 1);
    }
}
