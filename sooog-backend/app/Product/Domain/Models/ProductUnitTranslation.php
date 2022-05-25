<?php

namespace App\Product\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnitTranslation extends Model
{
    use HasFactory;
    protected $table = 'product_unit_translations';
    public $timestamps = false;
    protected $guarded = ['id'];

}
