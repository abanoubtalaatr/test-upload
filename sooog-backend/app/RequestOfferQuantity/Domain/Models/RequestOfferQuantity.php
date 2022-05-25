<?php

namespace App\RequestOfferQuantity\Domain\Models;

use App\Category\Domain\Models\Category;
use App\Product\Domain\Models\Product;
use App\Store\Domain\Models\Store;
use App\User\Domain\Models\User;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer $store_id
 * @property integer $category_id
 * @property integer $user_id
 * @property string $product_name
 * @property string $image
 * @property integer $amount
 * @property string $details
 * @property string $status
 * @property Store $store
 * @property Category $category
 * @property User $user
 * @property Collection $replies
 */
class RequestOfferQuantity extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'product_name',
        'image',
        'amount',
        'details',
        'status',
    ];

    protected $casts = [
        'store_id' => 'integer',
        'category_id' => 'integer',
        'user_id' => 'integer',
        'amount' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ReplyRequestOfferQuantity::class);
    }

    protected function setImageAttribute($value)
    {
        $image = explode("/", $value);
        $this->attributes['image'] = end($image);
    }

    protected function getImageAttribute($image)
    {
        if (isset($image) && $image != "")
            return Storage::disk('public')->url('request/offer/' . $image);
    }
}
