<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{

    public function index(Request $request)
    {
        $query = Enquiry::query();
        if ($request->has('enquiryType')) {
            $enquiryType = $request->enquiryType;
            $query->where('enquiryType', $enquiryType);
        }
        // Order by the created_at column in descending order (latest first)
        $query->latest('created_at');
        $enquiries = $query->get();
        return response()->json(["data" => $enquiries, "status" => 200]);
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), Enquiry::rules());
            if ($validator->fails()) {
                return response()->json([
                    "message" => 'Oops!' . $validator->errors()->first(), "status" => 400
                ]);
            }
            $enquiry = Enquiry::create($request->all());
            return response()->json(["data" => "Enquiry submitted. We will call you back soon!", "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function show(Request $request)
    {
        try {
            // Select only the desired fields
            $enquiry = Enquiry::where("enquiryType", $request->enquiryType)->get();

            if (!$enquiry) {
                return response()->json(["message" => "Enquiry not found.", "status" => 404]);
            }

            return response()->json(["data" => $enquiry, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }


    public function update(Request $request)
    {
        // Find the Enquiry record by its ID.
        $enquiry = Enquiry::find($request->id);

        // Check if the Enquiry record exists.
        if (!$enquiry) {
            return response()->json(["message" => "Enquiry not found.", "status" => 404]);
        }

        // Check if the 'madeEnquiry' field is present in the request and update it.
        if ($request->has("madeEnquiry")) {
            $enquiry->madeEnquiry = $request->madeEnquiry;
            $enquiry->save();
        }

        // Return a JSON response indicating success.
        return response()->json(["message" => "Enquiry updated successfully.", "status" => 200]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {        //
        $enquiry = Enquiry::find($request->id);
        if (!$enquiry) {
            return response()->json(["message" => "Enquiry not found.", "status" => 200]);
        }
        $enquiry->delete();
        return response()->json(["message" => "Enquiry deleted.", "status" => 200]);

    }
}
