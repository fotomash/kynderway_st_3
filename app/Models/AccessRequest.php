<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessRequest extends Model
{
    protected $table = 'access_requests';

    use HasFactory;

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function seeker()
    {
        return $this->belongsTo(User::class, 'seeker_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}
