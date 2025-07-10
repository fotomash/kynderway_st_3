<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_Types extends Model
{
    use HasFactory;

    protected $table = 'job_types';

    protected $fillable = [
        'profile_id',
        'jobtype'
    ];

    public static function modulename()
    {
        return "hello";
    }
}
