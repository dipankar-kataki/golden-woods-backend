<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $table = "projects";

    protected $guarded = [
    ];
    protected $casts = [
        "withinReach" => "array",
    ];
    public static function createRules()
    {
        return [
            'projectName' => 'required|string|unique:projects',
            'status' => 'required|string|in:completed,ongoing',
            'projectBanner' => 'required|mimes:jpg,png,jpeg,pdf',
            'projectImage1' => 'required|mimes:jpg,png,jpeg,pdf',
            'projectImage2' => 'required|mimes:jpg,png,jpeg,pdf',
            "propertyLogo" => 'nullable|mimes:jpg,png,jpeg,pdf',
            'projectVideo' => 'nullable|mimes:mp4,avi|max:500000',
            'description' => 'required|string',
            'overviewHeading' => 'required|string',
            'overviewContent' => 'required|string',
            'overviewFooter' => 'required|string',
            'location' => 'required|string|max:255',
            'withinReach' => 'required|string',
            'withinReachImage' => 'required|mimes:jpg,png,jpeg,pdf',
            'flatConfig' => 'required|string',
            'brochure' => 'nullable|mimes:jpg,png,jpeg,pdf',
        ];
    }

    public static function hideRules()
    {
        return [
            'isActive' => 'required|boolean',
        ];
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(ProjectGallery::class, 'projectId');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'project_amenities', 'projectId', 'amenityId');
    }
}
