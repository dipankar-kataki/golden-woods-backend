<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;
    protected $table = "amenities";
    protected $guarded = [];
    public static function createRules()
    {
        return [
            "amenityName" => "required|string",
            "amenityImage" => "required|file|mimes:avif,jpg,jpeg,png",
        ];
    }
    public static function updateRules()
    {
        return [
            "amenityName" => "sometimes|string",
            "amenityImage" => "sometimes|file|mimes:avif,jpg,jpeg,png",
        ];
    }

}
