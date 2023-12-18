<?php

namespace App\Http\Controllers;

use App\Models\ProjectAmenity;
use App\Models\ProjectGallery;
use App\Models\Project;
use App\Models\Amenity;

use Illuminate\Http\Request;

class ProjectAmenityController extends Controller
{
    public function create(Request $request)
    {
        try {
            // Find the project by ID
            $project = Project::findOrFail($request->projectId);

            ProjectAmenity::where("projectId", $request->projectId)->delete();
            // Add new project amenities
            foreach ($request->amenityId as $amenity) {
                ProjectAmenity::create([
                    "projectId" => $request->projectId,
                    "amenityId" => $amenity,
                ]);
            }
            return response()->json(["message" => "Amenities added to project.", "status" => 201]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(["message" => "Project not found.", "status" => 404]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something went wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function show(Request $request)
    {
        try {
            $projectId = $request->id;
            $project = Project::find($projectId);

            if (!$project) {
                return response()->json(["message" => "Project not found.", "status" => 404]);
            }

            // Assuming you have a pivot table named 'project_amenities'
            $amenities = $project->amenities()->select('amenityName', 'amenityImage')->get();
            return response()->json(["data" => $amenities, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }

    }
}
