<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AmenityController extends Controller
{   
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $data = Amenity::paginate($perPage);    
        return response()->json(["data"=>$data, "status"=>200]);
    }
  
    public function create(Request $request)
    {
        $validator = Validator::make(request()->all(), Amenity::createRules());
        if($validator->fails()){
            return response()->json(["message" => 'Oops!' . $validator->errors()->first(), "status" => 400]);
        }

        $data = [
            'amenityName' => $request->input('amenityName'),
            'amenityImage' => $request->file('amenityImage')->store('amenity'),
        ];

        Amenity::create($data);
        return response()->json(["data"=>"Amenity created successfully.","status"=> 201]);
    }

    public function show(Request $request)
    {
        $amenity = Amenity::find($request->id);
        if(empty($amenity)) {
            return response()->json(["message"=> "Amenity not found."],404);
        }
        $amenity->amenityImage = asset($amenity->amenityImage);
        return response()->json(["data"=>$amenity, "status"=>200]);
    }

    public function update(Request $request)
    {
        if(!$request->id){
            return response()->json(["message"=> "Invalid request. Please send Id.","status"=>404]);
        }
        $amenity = Amenity::find($request->id);
        // dump($request->input("amenityName"));
        // dump($request->amenityName);

        if(empty($amenity)) {
            return response()->json(["message"=> "Requested amenity not found.","status"=>404]);
        }
        if($request->has("amenityName")){
            $amenity->amenityName = $request->input("amenityName");
        }
        if ($request->hasFile('amenityImage')) {
            if (Storage::exists($amenity->amenityImage)) {
                Storage::delete($amenity->amenityImage);
            }
            $newFilePath =  $request->file('amenityImage')->store('amenity');         
            $amenity->amenityImage = $newFilePath;
        }
        $amenity->save();
        return response()->json(["message"=>"Amenity updated successfully", "status"=>200]);
    }

    public function destroy(Request $request)
    {
        $amenity = Amenity::find($request->id);
        if(!$amenity){
            return response()->json(["message"=>"Amenity not found.", "status"=>404]);
        }
        Storage::delete($amenity->amenityImage);
        $amenity->delete();
        return response()->json(["message"=>"Amenity deleted successfully", "status"=>200]);
    }
}
