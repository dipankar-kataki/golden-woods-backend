<?php

namespace App\Http\Controllers;

use App\Models\ProjectGallery;
use App\Models\Project;
use App\Models\Amenity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ProjectGalleryController extends Controller
{

    public function create(Request $request)
    {
        ProjectGallery::where("projectId", $request->id)
            ->where("imageType", $request->imageType)
            ->delete();

        $validator = Validator::make($request->all(), ProjectGallery::rules());
        if ($validator->fails()) {
            return response()->json(["message" => "Oops!" . $validator->errors()->first(), "status" => 400]);
        }
        $projectId = $request->id;
        $project = Project::find($projectId);
        if (!$project) {
            return response()->json(["message" => "Project not found.", "status" => 404]);
        }
        // Assuming 'image' is an array of files
        $uploadedFiles = $request->file('image');
        // Validate if files were uploaded
        if (!$uploadedFiles) {
            return response()->json(["message" => "No files uploaded.", "status" => 400]);
        }
        // Iterate through each uploaded file
        foreach ($uploadedFiles as $file) {
            // Validate if the file is an image (you may want to add more specific validation)
            $data = $file->store('gallery');  // store() method automatically generates a unique filename
            ProjectGallery::create([
                "projectId" => $request->id,
                "image" => $data,
                "imageType" => $request->imageType,
            ]);
        }
        return response()->json(['message' => 'Files uploaded successfully', "status" => 201]);
    }


    public function index(Request $request)
    {
        $projectId = $request->id;
        $imageType = $request->imageType;

        $projectGalleries = ProjectGallery::where("projectId", $projectId)
            ->where("imageType", $imageType)
            ->get();

        if ($projectGalleries->isEmpty()) {
            return response()->json(["message" => "No galleries found for the specified projectId.", "status" => 404]);
        }
        return response()->json(["data" => $projectGalleries, "status" => 200]);
    }

    public function deleteGalleyImageItem(Request $request)
    {
        try {
            $projectId = $request->id;

            $galleryItems = ProjectGallery::where("projectId", $projectId)->get();

            if ($galleryItems->isEmpty()) {
                return response()->json(["message" => "No Gallery Items found for the specified Project Id", "status" => 404]);
            }

            foreach ($galleryItems as $galleryItem) {
                $filePath = $galleryItem->image;

                if ($filePath && Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }

                $galleryItem->delete();
            }

            return response()->json(["message" => "Gallery Items deleted successfully", "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error. ' . $e->getMessage(), "status" => 500]);
        }
    }

    public function updateSpecificGalleryImage(Request $request)
    {
        try {
            $galleryItem = ProjectGallery::find($request->id);
            if (!$galleryItem) {
                return response()->json(["message" => "No Gallery Item found for the specified Id", "status" => 404]);
            }
            $oldFilePath = $galleryItem->image;
            if ($oldFilePath && Storage::exists($oldFilePath)) {
                Storage::delete($oldFilePath);
            }
            $galleryItem->image = $request->file('image')->store('image');
            $galleryItem->save();
            return response()->json(["message" => "Gallery Image Modified Successfully.", "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error. ' . $e->getMessage(), "status" => 500]);
        }
    }

    public function deleteSpecificGalleryImage(Request $request)
    {
        try {
            $galleryItem = ProjectGallery::find($request->id);
            if (!$galleryItem) {
                return response()->json(["message" => "No Gallery Item found for the specified Id", "status" => 404]);
            }
            $oldFilePath = $galleryItem->image;
            if ($oldFilePath && Storage::exists($oldFilePath)) {
                Storage::delete($oldFilePath);
            }
            return response()->json(["message" => "Gallery Image deleted Successfully.", "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error. ' . $e->getMessage(), "status" => 500]);
        }
    }

}
