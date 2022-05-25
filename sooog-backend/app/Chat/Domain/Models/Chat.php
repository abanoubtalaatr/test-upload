<?php

namespace App\Chat\Domain\Models;

use App\Store\Domain\Models\Store;
use App\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function members()
    {
        return $this->hasMany(ChatMember::class,'chat_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class,'chat_id');
    }

}
