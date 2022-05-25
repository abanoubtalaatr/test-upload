<?php

namespace App\Ad\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
}
