<?php

namespace App\Http\Controllers;

use App\Models\ChatAnswer;
use App\Models\ChatQuestion;
use Illuminate\Http\Request;
use App\Models\ChatSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatSessionController extends Controller
{
    public function index()
    {
        try {
            $chatSession = ChatSession::all();
            return response()->json(['$chatSession' => $chatSession, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $chatSession = ChatSession::findOrFail($id);
            return response()->json(['chatQuestion' => $chatSession, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ChatQuestion::createRules());

            if ($validator->fails()) {
                return response()->json(["message" => "Oops!" . $validator->errors()->first(), "status" => 400]);
            }
            DB::beginTransaction();
            ChatQuestion::create($request->all());
            DB::commit();
            return response()->json(['message' => 'Chat session saved successfully', 'status' => 201]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $chatQuestion = ChatQuestion::find($id);
            if (!$chatQuestion) {
                return response()->json(['message' => 'Chat session not found.', 'status' => 400]);
            }
            $chatQuestion->update($request->all());

            return response()->json(['message' => 'Chat session updated successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $ChatAnswer = ChatSession::findOrFail($id);
            $ChatAnswer->delete();

            return response()->json(['message' => 'Chat session deleted successfully', "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }
}
