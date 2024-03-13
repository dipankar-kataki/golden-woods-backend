<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $blogs_count = Blog::count();
        return view('admin.dashboard.dashboard')->with(['blogs_count' => $blogs_count]);
    }
}
