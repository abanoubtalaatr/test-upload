<?php

namespace App\Admin\Domain\Models;

use App\Chat\Domain\Models\Chat;
use App\Store\Domain\Models\Store;
use App\User\Domain\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use App\Infrastructure\Domain\Filters\Filterable;

class Admin extends Authenticatable implements JWTSubject
//class User extends Authenticatable
{
    //use HasApiTokens;
   // use HasFactory;
    //use HasProfilePhoto;
    use Notifiable, HasRoles, Filterable;
    //use TwoFactorAuthenticatable;

    //protected $guard_name = 'admin';
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        "id",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'store_id' => $this->store_id
        ];
    }

    protected function setAvatarAttribute($value)
    {
        $image = explode("/", $value);
        if(!in_array('default-user.jpg', $image))
            $this->attributes['avatar'] = end($image);
        else
            $this->attributes['avatar'] = null;
    }
    protected function getAvatarAttribute($image)
    {
        if (isset($image) && $image != ""):
            return \Storage::disk('public')->url('/admins/'.$image);
        else:
            return url("assets/images/default/default-user.jpg");
        endif;
    }

    public function allRoles() {
        // return $this->belongsToMany(
        //     'App\Admin\Domain\Models\Role',
        //     'model_has_roles',
        //     'model_id',
        //     'role_id'
        // );

        return $this->morphToMany(
            'App\Admin\Domain\Models\Role',
            'model_has_roles',
            'model_id',
            'role_id'
        );
    }

    public function attachments()
    {
        return $this->morphMany('App\Uploader\Domain\Models\Attachment', 'creatable');
    }

    public function store()
    {
        return $this->belongsTo('App\Store\Domain\Models\Store');
    }

    public function orderStatuses()
    {
        return $this->morphMany('App\Order\Domain\Models\OrderStatus', 'statusable');
    }

    public function tokens()
    {
        return $this->morphMany('App\User\Domain\Models\DeviceToken', 'tokenable');
    }

    public function user()
    {
        return $this->hasOne(User::class,'admin_id');
    }

}
