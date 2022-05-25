<?php

namespace App\BankAccount\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
}
