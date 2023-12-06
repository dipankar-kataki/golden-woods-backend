<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $guarded = [
 
    ];

    public static function rules(){
        return [
            "name" => "required|string",
            "phone" => "required|numeric|digits:10",
            "email" => "sometimes|email",
            "message" => "sometimes|string",
        ];
    }

}
