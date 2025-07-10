<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Connections extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_connections';

    protected $guarded = [];

    public function jobProvider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function jobPoster()
    {
        return $this->belongsTo(User::class, 'job_userid');
    }

    public function job()
    {
        return $this->belongsTo(Job_Posts::class, 'jobappliedid');
    }

    public function profile()
    {
        return $this->belongsTo(Profile_Posts::class, 'providerprofileid');
    }
}
