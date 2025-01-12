<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $keyType = "int";
    protected $table = "comments";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;

}
