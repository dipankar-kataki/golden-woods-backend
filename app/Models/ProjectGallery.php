<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model
{
    use HasFactory;
    protected $table = "project_galleries";
    protected $guarded = [
    ];

    public static function rules()
    {
        return [
            "imageType" => "required|string|in:exterior,interior,architectural",
            "image" => "required",
        ];
    }

}
