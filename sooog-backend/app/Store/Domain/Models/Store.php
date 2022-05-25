<?php

namespace App\Store\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use App\Chat\Domain\Models\Chat;
use App\Location\Domain\Models\Country;
use App\Package\Domain\Models\StorePackage;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    use Translatable, HasFactory, Filterable;
    public $translatedAttributes = ['name'];
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'has_delivery_service' => 'boolean'
    ];

    //status = [0 => 'new', 1 => 'accepted store', 2 => 'rejected store']
    //is_active = [0 => 'in active store and accepted', 1 => 'active store and accepted']

    public function city()
    {
        return $this->belongsTo('App\Location\Domain\Models\City');
    }

    public function bankCountry()
    {
        return $this->belongsTo(Country::class,'bank_country_id');
    }

    protected function setImageAttribute($value)
    {
        $image = explode("/", $value);
        $this->attributes['image'] = end($image);
    }

    protected function getImageAttribute($image)
    {
        if (isset($image) && $image != ""):
            return \Storage::disk('public')->url('/stores/' . $image);
        else:
            //return "";
            if ($this->type == 'centers')
                return url("assets/images/default/center.png");
            else
                return url("assets/images/default/store.png");
        endif;
    }


    protected function setCommercialRegistryPhotoAttribute($value)
    {
        $image = explode("/", $value);
        $this->attributes['commercial_registry_photo'] = end($image);
    }

    protected function getCommercialRegistryPhotoAttribute($image)
    {
        if (isset($image) && $image != ""):
            return \Storage::disk('public')->url('/stores/' . $image);
        else:
            return "";
        endif;
    }

    public function scopeActive($query, $is_active)
    {
        if ($is_active == 1) {
            return $query->where('status', 1)->where('is_active', 1);
        } else {
            return $query->where('is_active', 0);
        }
    }

    public function scopeNearest($query, $latitude, $longitude)
    {
        return $query->select(DB::raw('*, ( 6371 * acos( cos( radians(' .
            $latitude . ') ) * cos( radians( `latitude` ) ) * cos(radians( `longitude` ) - radians(' .
            $longitude . ') ) + sin( radians(' . $latitude .
            ') ) * sin( radians( `latitude` ) ) ) ) as distance'))
//            ->having('distance', '<=', 50)
            ->orderBy('distance');
    }

    public function admins()
    {
        return $this->hasMany('App\Admin\Domain\Models\Admin');
    }

    public function products()
    {
        return $this->hasMany('App\Product\Domain\Models\Product');
    }

    public function promoCodes()
    {
        return $this->belongsToMany('App\PromoCode\Domain\Models\PromoCode');
    }

    public function allPackages()
    {
        return $this->hasMany(StorePackage::class,'store_id');
    }

    public function activePackage()
    {
        return $this->hasOne(StorePackage::class,'store_id')->where('is_active',1)
            ->whereDate('expire_at','>=',Carbon::today());
    }

    public function chats()
    {
        return $this->hasMany(Chat::class,'store_id')->distinct('user_id');
    }

    public function scopeHasActivePackage($query)
    {
        return $query->whereHas('activePackage');
    }

    public function requestOfferQuantities(): HasMany
    {
        return $this->hasMany(RequestOfferQuantity::class);
    }

    public function replyRequestOfferQuantities(): HasMany
    {
        return $this->hasMany(ReplyRequestOfferQuantity::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('is_paid', function (Builder $builder) {
            $builder->where('is_paid', '=', 1);
        });
    }
}
