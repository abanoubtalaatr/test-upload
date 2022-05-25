<?php

namespace App\RequestOfferQuantity\Domain\Models;

use App\Store\Domain\Models\Store;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ReplyRequestOfferQuantity extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_offer_quantity_id',
        'store_id',
        'offer_price',
        'invoice',
        'status',
        'notes'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function requestOfferQuantity(): BelongsTo
    {
        return $this->belongsTo(RequestOfferQuantity::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    protected function setInvoiceAttribute($value)
    {
        $image = explode("/", $value);
        $this->attributes['invoice'] = end($image);
    }

    protected function getInvoiceAttribute($image)
    {
        if (isset($image) && $image != "")
            return Storage::disk('public')->url('/reply/invoices/' . $image);
    }
}
