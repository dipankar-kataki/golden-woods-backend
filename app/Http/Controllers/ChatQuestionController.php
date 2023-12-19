<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatQuestionController extends Controller
{
    public function index()
    {
        try {
            $chatQuestions = ChatQuestion::all();
            return response()->json(['chatQuestions' => $chatQuestions, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $chatQuestion = ChatQuestion::findOrFail($id);
            return response()->json(['chatQuestion' => $chatQuestion, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ChatQuestion::createRules());

            if ($validator->fails()) {
                return response()->json(["message" => "Oops!" . $validator->errors()->first(), "status" => 400]);
            }
            DB::beginTransaction();
            ChatQuestion::create($request->all());
            DB::commit();
            return response()->json(['message' => 'Chat question created successfully', 'status' => 201]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate(ChatQuestion::createRule());

            $chatQuestion = ChatQuestion::findOrFail($id);
            $chatQuestion->update($request->all());

            return response()->json(['message' => 'Chat question updated successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $chatQuestion = ChatQuestion::findOrFail($id);
            $chatQuestion->delete();

            return response()->json(['message' => 'Chat question deleted successfully', "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }
}
