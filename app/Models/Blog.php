<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guarded= [];
    public static function createRules()
    {
        return [
            'title' => 'required|string',
            'blogImage' => 'required|mimes:jpg,png,jpeg',
            'author' => 'required|string',
            'content' => 'required|string',
        ];
    }
    
}
