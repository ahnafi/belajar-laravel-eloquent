<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = "employees";
    protected $keyType = "string";
    public $timestamps = true;
    protected $primaryKey = "id";
    public $incrementing = false;


}
