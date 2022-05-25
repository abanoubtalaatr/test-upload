<?php

namespace App\Chat\Domain\Models;

use App\Store\Domain\Models\StoreAdmin;
use App\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function sender()
    {
        if ($this->sender_type == 'user') {
            return $this->belongsTo(User::class, 'sender_id');
        } else {
            return $this->belongsTo(StoreAdmin::class, 'sender_id');
        }
    }
}
