<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model
{
    use HasFactory;
    protected $guarded = [
    ];

    public static function rules(){
        return [
            "imageType" => "required|string|in:exterior,interior,architectural",
            "projectId" => "required|integer|exists:projects,id",
            "image" => "required|file|mimes:avif,jpg,jpeg,png",
        ];
    }
    
}
