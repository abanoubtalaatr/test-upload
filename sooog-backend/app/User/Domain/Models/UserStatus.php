<?php

namespace App\User\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    use HasFactory;
    protected $guarded =[
		'id'
	];
	
	public function user()
    {
        return $this->belongsTo('App\User\Domain\Models\User');
    }
}
