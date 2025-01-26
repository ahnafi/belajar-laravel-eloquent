<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $table = "persons";
    public $incrementing = true;
    public $timestamps = true;

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return $this->first_name . " " . $this->last_name;
            },

            set: function (string $value): array {
                $names = explode(" ", $value);
                return [
                    "first_name" => $names[0],
                    "last_name" => $names[1] ?? ""
                ];
            }
        );
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(get: function ($value, $attribute): string {
            return strtoupper($value);
        }, set: function ($value): array {
            return [
                'first_name' => strtoupper($value)
            ];
        });
    }
}
