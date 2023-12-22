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
            'user_id' => 'required|exists:web_user,id',
            'question_id' => 'required|exists:chat_question,id',
            'answer' => 'required|string',
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
