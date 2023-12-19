<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatQuestion extends Model
{
    use HasFactory;
    protected $table = "chat_question";
    public static function createRule()
    {
        return [
            'questionNumber' => 'required|numeric|unique:chat_question',
            'question' => 'required|string',
        ];
    }
}
