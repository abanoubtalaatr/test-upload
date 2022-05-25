<?php

namespace App\PromoCode\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
}
