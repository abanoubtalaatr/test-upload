<?php

namespace App\Package\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
}
