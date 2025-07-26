<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Conversations;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'sender_id', 'message', 'is_read'];
    
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function conversation() {
    return $this->belongsTo(Conversations::class);
}


}
