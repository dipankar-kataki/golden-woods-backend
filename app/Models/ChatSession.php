<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    use HasFactory;
    protected $table = "chat_session";

    protected $guarded = [];
    public static function createRule()
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|string|size:10', // Assuming phone is a string with a length of 10
            'email' => 'nullable|email',
            'question' => 'required|exists:chat_question,id',
            'answer' => 'required|exists:chat_answer,id',
        ];
    }
}
