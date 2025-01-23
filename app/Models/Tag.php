<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = "string";
    protected $table = 'tags';
    public $incrementing = false;
    public $timestamps = false;

    public function products(): MorphToMany
    {
        return $this->morphToMany(Product::class, 'taggable');
    }

    public function vouchers(): MorphToMany
    {
        return $this->morphToMany(Voucher::class, 'taggable');
    }
}
