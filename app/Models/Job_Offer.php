<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_Offer extends Model
{
    use HasFactory;

    protected $table = 'job_offers';

    protected $guarded = [];

    public function job_post()
    {
        return $this->hasOne(Job_Posts::class, 'id', 'job_post_id');
    }
}
