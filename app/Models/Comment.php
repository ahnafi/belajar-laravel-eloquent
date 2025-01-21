<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{

    protected $keyType = "int";
    protected $table = "comments";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

    protected $attributes = [
        "title" => "default title",
        "comment" => "default comment"
    ];

    function commentable(): MorphTo
    {
        return $this->morphTo();
    }

}
