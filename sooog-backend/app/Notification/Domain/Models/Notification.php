<?php

namespace App\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Infrastructure\Domain\Filters\Filterable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification as BaseNotification;

class Notification extends DatabaseNotification 
{
    use Filterable;
    //public $translatedAttributes = ['title', 'body'];
    //protected $guarded = ['id'];


}
