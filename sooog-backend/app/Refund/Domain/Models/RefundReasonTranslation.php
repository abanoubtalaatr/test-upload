<?php

namespace App\Refund\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundReasonTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
}
