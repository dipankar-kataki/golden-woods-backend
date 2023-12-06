<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $table = "enquiries";
    protected $guarded = [];

    public static function rules()
    {
        return [
            "name" => "required|string|max:255",
            "email" => "sometimes|email|max:255",
            "phone" => "required|numeric|digits:10",
            "projectId" => "sometimes|integer|exists:projects,id",
            "flatType" => "sometimes|string|in:1bhk,2bhk,3bhk,4bhk",
            "enquiryType" => "sometimes|in:price,general",
        ];
    }
    
    

}
