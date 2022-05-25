<?php

namespace App\AppContent\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class ContactType extends Model
{
    use HasFactory, Translatable;
    protected $guarded = ['id'];
    public $translatedAttributes = ['name'];
}
