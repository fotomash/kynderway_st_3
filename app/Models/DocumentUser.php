<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentUser extends Model
{
    use HasFactory;

    protected $table = 'documents_users';
    protected $guarded = [];

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
