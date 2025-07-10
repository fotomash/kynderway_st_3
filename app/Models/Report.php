<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function reportUsers()
    {
        return $this->hasMany(ReportUser::class);
    }

    public function job()
    {
        return $this->belongsTo(Job_Posts::class, 'job_post_id', 'id')->withTrashed();
    }

    public function profile()
    {
        return $this->belongsTo(Profile_Posts::class, 'profile_post_id', 'id')->withTrashed();
    }

    public function assigned()
    {
        return $this->belongsto(User::class, 'assigned_user_id', 'id')->latest();
    }
}
