<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAmenity extends Model
{
    use HasFactory;
    protected $fillable = [
        "projectId",
        "amenityId",
    ];
    protected $casts = [
        'amenityId' => 'array',
    ];

    public static function rules(){
        return [
            "projectId"=>"required|integer|exists:projects,id",
            "amenityId"=>"required|integer|exists:amenities,id",
        ];
    }
}
