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
            'web_user' => 'required|exists:web_user,id',
            'question' => 'required|exists:chat_question,id',
            'answer' => 'required|exists:chat_answer,id',
        ];
    }
    public function webUser()
    {
        return $this->belongsTo(WebUser::class, 'web_user');
    }

    public function question()
    {
        return $this->belongsTo(ChatQuestion::class, 'question');
    }

    public function answer()
    {
        return $this->belongsTo(ChatAnswer::class, 'answer');
    }

}
