<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
    protected $table = "customers_likes_products";
    public $timestamps = false;

    public function setAttribute($key, $value)
    {
        if (in_array($key, ['updated_at'])) {
            return $this;
        }
        return parent::setAttribute($key, $value);
    }

    protected $foreignKey = "customer_id";
    protected $relatedKey = "product_id";

    function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}

