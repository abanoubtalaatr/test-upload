<?php

namespace App\User\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
	protected $guarded = [
		'id'
	];
	protected $table = 'user_addresses';
	protected $casts = [
        'is_primary' => 'boolean'
    ];
	public function user()
    {
        return $this->belongsTo('App\User\Domain\Models\User');
    }

    public function city()
    {
        return $this->belongsTo('App\Location\Domain\Models\City');
    }

    public function state()
    {
        return $this->belongsTo('App\Location\Domain\Models\State');
    }

    public function country()
    {
        return $this->belongsTo('App\Location\Domain\Models\Country');
    }

    public function orders()
    {
        return $this->hasMany('App\Order\Domain\Models\Order');
    }
}

