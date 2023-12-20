<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatQuestion extends Model
{
    use HasFactory;
    protected $table = "chat_question";
    protected $guarded = [];
    public static function createRule()
    {
        return [
            'questionNumber' => 'required|numeric',
            'question' => 'required|string',
        ];
    }
    public function answers()
    {
        return $this->hasMany(ChatAnswer::class, 'question');
    }
}
