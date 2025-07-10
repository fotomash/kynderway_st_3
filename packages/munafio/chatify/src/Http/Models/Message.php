<?php

namespace Chatify\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User_Connections;
use App\Models\Job_Posts;

class Message extends Model
{
    use SoftDeletes;

    public function connection(){
        return $this->belongsTo(User_Connections::class,'reference_id');
    }
}
