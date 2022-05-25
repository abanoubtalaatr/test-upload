<?php

namespace App\BankAccount\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Infrastructure\Domain\Filters\Filterable;

class BankAccount extends Model
{
    use Translatable, HasFactory, Filterable;
    public $translatedAttributes = ['name'];
    public $translationForeignKey = 'bank_account_id';
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query, $is_active)
    {
        if($is_active == 1){
            return $query->where('is_active', 1);
        }else{
            return $query->where('is_active', 0);
        }
    }

    protected function setImageAttribute($value)
    {
        $image = explode("/", $value);
        $this->attributes['image'] = end($image);
    }
    protected function getImageAttribute($image)
    {
        if (isset($image)):
            return \Storage::disk('public')->url('/bank_accounts/'.$image);
        else:
            return "";
        endif;
    }

    public function orders()
    {
        return $this->hasMany('App\Order\Domain\Models\BankTransfer', 'bank_account_id', 'id');
    }

}
