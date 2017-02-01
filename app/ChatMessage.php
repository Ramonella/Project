<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = "chatmessages";
    protected $fillable = ['body', 'emitter', 'receiver'];
}
