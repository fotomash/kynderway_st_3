<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerificationDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'verification_documents';
    protected $guarded = [];

    protected $casts = [
        'verification_data' => 'array',
    ];
}
