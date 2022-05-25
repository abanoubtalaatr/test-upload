<?php

namespace App\Chat\Domain\Models;

use App\Store\Domain\Models\StoreAdmin;
use App\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMember extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function user()
    {
        if ($this->user_type == 'user') {
            return $this->belongsTo(User::class, 'user_id');
        } else {
            return $this->belongsTo(StoreAdmin::class, 'user_id');
        }
    }
}
