<?php
namespace App\Store\Domain\Models;

use App\Admin\Domain\Models\Admin;

class StoreAdmin extends Admin {
	protected $table = 'admins';
   protected $guard_name = 'store';



}
