<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        "created_at" => "datetime:U"
    ];

    protected $fillable = [
        'id',
        'name',
        'description'
    ];

    protected static function booted()
    {
        parent::booted();
        self::addGlobalScope(new IsActiveScope());
    }

    public function products(): HasMany
    {
        return $this->HasMany(Product::class, "category_id", "id");
    }

    public function cheapestProduct(): HasOne
    {
        return $this->hasOne(Product::class, "category_id", "id")->oldest("price");
    }

    function mostExpensiveProduct(): HasOne
    {
        return $this->hasOne(Product::class, "category_id", "id")->latest("price");
    }

    function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            Product::class,
            'category_id',
            'product_id',
            'id',
            'id'
        );
    }

}
