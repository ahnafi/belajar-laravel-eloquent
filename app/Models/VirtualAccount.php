<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VirtualAccount extends Model
{
    use HasFactory;

    protected $table = "virtual_accounts";
//    protected $keyType = "integer";
//    protected $primaryKey = "id";

    public $timestamps = false;

    function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, "wallet_id", "id");
    }
}
