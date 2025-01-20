<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "images";
    protected $keyType = "int";
    protected $primaryKey = "id";

    function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
