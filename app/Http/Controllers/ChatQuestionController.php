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
            $chatQuestion = ChatQuestion::with("answers")->get();
            return response()->json(['chatQuestions' => $chatQuestion, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $chatQuestion = ChatQuestion::find($id)->with("answers")->get();

            $chatQuestionLength = ChatQuestion::count();
            if ($chatQuestionLength < $id) {
                return response()->json(['chatQuestion' => null, "message" => "Thank you for your time. Our team will contact you shortly.", "status" => 200]);
            }
            return response()->json(["data" => ['chatQuestion' => $chatQuestion], "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.', "status" => 500]);
        }
    }

    public function create(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), ChatQuestion::createRule());

            if ($validator->fails()) {
                return response()->json(["message" => "Oops!" . $validator->errors()->first(), "status" => 400]);
            }
            // dump($request);

            DB::beginTransaction();
            $chatQuestionData = $request->only('question', 'questionNumber');
            ChatQuestion::create($chatQuestionData);
            DB::commit();

            return response()->json(['message' => 'Chat question created successfully', 'status' => 201]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["message" => 'Internal server error.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate(ChatQuestion::createRule());

            $chatQuestion = ChatQuestion::find($request->id)->first();
            if (!$request->id) {
                return response()->json(["message" => 'No question found.', "status" => 404]);
            }
            $chatQuestion['question'] = $request->question;
            $chatQuestion->save();

            return response()->json(['message' => 'Chat question updated successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Internal server error.' . $e->getMessage(), "status" => 500]);
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
