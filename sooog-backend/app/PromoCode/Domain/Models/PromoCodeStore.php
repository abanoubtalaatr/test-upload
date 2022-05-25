<?php

namespace App\PromoCode\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeStore extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
}
