<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    //
    protected $fillable = ['status','chat_id','receiver','sender'];
}
