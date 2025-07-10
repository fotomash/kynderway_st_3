<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailingJob extends Model
{
    use HasFactory;

    protected $table = 'mailing_job';

    protected $guarded = [];
}
