<?php

namespace App\User\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
	protected $fillable =[
		'phone',
		'token',
		'created_at',
		'country_code'
	];
	public $timestamps = false;
	protected $primaryKey = 'phone';
}
