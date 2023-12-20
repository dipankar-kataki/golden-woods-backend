<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebUser extends Model
{
    use HasFactory;
    protected $table = "web_user";
    protected $guarded = [];

    public static function createRule()
    {
        return [
            "name" => "required|string",
            "email" => "required|string",
            "phone" => "required|string",
            "preferredMode" => "required|string"
        ];
    }
    public static function updateRule()
    {
        return [
            "name" => "nullable|string",
            "email" => "nullable|string",
            "phone" => "nullable|string",
            "preferredMode" => "nullable|string",
            "madeContact" => "nullable|boolean", // Assuming 'madeContact' is a boolean field
        ];
    }
    public function chatSessions()
    {
        return $this->hasMany(ChatSession::class, 'web_user');
    }
}
