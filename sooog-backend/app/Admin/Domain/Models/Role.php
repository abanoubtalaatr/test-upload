<?php

namespace App\Admin\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Infrastructure\Domain\Filters\Filterable;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use Translatable, HasFactory, Filterable;
    public $translatedAttributes = ['display_name'];
    protected $fillable = ['name', 'is_active', 'guard_name', 'store_id'];
}
