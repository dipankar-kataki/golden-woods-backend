<?php

namespace App\Http\Controllers;

use App\Models\WebUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebUserController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), WebUser::createRule());
            if ($validator->fails()) {
                return response()->json(["message" => 'Oops!' . $validator->errors()->first(), "status" => 400]);
            }
            $user = WebUser::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'preferredMode' => $request->input('preferredMode'),
            ]);
            return response()->json(["data" => "Admin created successfully", "status" => 201]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }
    public function index(Request $request)
    {
        try {
            $users = WebUser::latest()->paginate();
            return response()->json(["data" => $users, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }
    public function show(Request $request)
    {
        try {
            $webUser = WebUser::find($request->id);
            if (!$webUser) {
                return response()->json(["message" => 'WebUser not found', "status" => 404]);
            }
            $webUserWithChatSessions = $webUser->load('chatSessions');
            return response()->json(["data" => $webUserWithChatSessions, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }
    public function update(Request $request)
    {
        try {
            // Find the WebUser by ID
            $webUser = WebUser::find($request->id);

            if (!$webUser) {
                return response()->json(["message" => 'WebUser not found', "status" => 404]);
            }

            // Validate and update the WebUser
            $request->validate(WebUser::updateRule());

            $webUser->update($request->all());

            // Eager load the ChatSessions relationship
            $webUserWithChatSessions = $webUser->load('chatSessions');

            return response()->json(["data" => $webUserWithChatSessions, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }
  
}
