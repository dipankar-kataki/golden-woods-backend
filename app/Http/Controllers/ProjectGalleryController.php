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
class ProjectGalleryController extends Controller
{

    public function create(Request $request)
    {   

        $validator = Validator::make($request->all(), ProjectGallery::rules());
        if ($validator->fails()) {
            return response()->json(["message" => "Oops!" . $validator->errors()->first(), "status" => 400]);
        }
        $uploadedFiles = $request->file('image');
        if (is_array($uploadedFiles) && count($uploadedFiles) > 0) {
            foreach ($uploadedFiles as $file) {
                $data = $file->storeAs('gallery');
                ProjectGallery::create([
                "projectId" => $request->id,
                "images" => $data,
                "imageType"=>$request->imageType]);
            }
            return response()->json(['message' => 'Files uploaded successfully',"status"=>201]);
        } elseif (!is_array($uploadedFiles) && $uploadedFiles !== null) {
            // Only one file uploaded
            $data = $uploadedFiles->store('gallery');
            ProjectGallery::create([
                "projectId" => $request->id,
                "images" => $data,
                "imageType"=>$request->imageType]);
    
                return response()->json(['message' => 'File uploaded successfully', "status"=>201]);
        }
        return response()->json(['message' => 'No files provided.']);
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
        return response()->json(["data"=> $projectGalleries, "status"=>200]);
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

    public function updateSpecificGalleryImage(Request $request){
       try{
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
       }catch (\Exception $e){
        return response()->json(["message" => 'Internal server error. '.$e->getMessage(), "status" => 500]);
       }
    }

    public function deleteSpecificGalleryImage(Request $request){
        try{
         $galleryItem = ProjectGallery::find($request->id);
         if (!$galleryItem) {
             return response()->json(["message" => "No Gallery Item found for the specified Id", "status" => 404]);
         }
         $oldFilePath = $galleryItem->image;
         if ($oldFilePath && Storage::exists($oldFilePath)) {
             Storage::delete($oldFilePath);
        }
         return response()->json(["message" => "Gallery Image deleted Successfully.", "status" => 200]);
        }catch (\Exception $e){
         return response()->json(["message" => 'Internal server error. '.$e->getMessage(), "status" => 500]);
        }
     }
 
}
