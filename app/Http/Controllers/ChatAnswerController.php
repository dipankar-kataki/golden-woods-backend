<?php

namespace App\Http\Controllers;

use App\Models\ChatQuestion;
use Illuminate\Http\Request;
use App\Models\ChatAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatAnswerController extends Controller
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
            $chatAnswer = ChatQuestion::findOrFail($id);
            return response()->json(['chatAnswer' => $chatAnswer, "status" => 200]);
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
            return response()->json(['message' => 'Chat answer created successfully', 'status' => 201]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $chatAnswer = ChatQuestion::find($id);
            if (!$chatAnswer) {
                return response()->json(['message' => 'Chat answer not found.', 'status' => 400]);
            }
            $chatAnswer->update($request->all());

            return response()->json(['message' => 'Chat answer updated successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $ChatAnswer = ChatAnswer::findOrFail($id);
            $ChatAnswer->delete();

            return response()->json(['message' => 'Chat answer deleted successfully', "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }
}
