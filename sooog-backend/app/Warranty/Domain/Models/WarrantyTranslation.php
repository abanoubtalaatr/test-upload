<?php

namespace App\Warranty\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'locale', 'warranty_id'];
}
