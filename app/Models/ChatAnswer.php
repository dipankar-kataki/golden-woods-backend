<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAnswer extends Model
{
    use HasFactory;
    protected $table = "chat_answer";
    protected $guarded = [];
    public static function createRule()
    {
        return [
            'question' => 'required|exist:chat_question,id',
            'answer' => 'required|string|size:10',
        ];
    }
    public function question()
    {
        return $this->belongsTo(ChatQuestion::class, "question", 'id');
    }

}
