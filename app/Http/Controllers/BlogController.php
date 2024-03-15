<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        try {
            // Fetch all blogs in descending order of creation date
            $blogs = Blog::orderBy('created_at', 'desc')->get();

            return response()->json(["data" => $blogs, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function create(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), Blog::createRules());

            if ($validator->fails()) {
                return response()->json(["message" => "Validation failed", "errors" => $validator->errors(), "status" => 400]);
            }

            // Create a new blog record
            $blog = Blog::create([
                'title' => $request->input('title'),
                'blogImage' => $request->file('blogImage')->store('blog_images'), // Adjust the storage path
                'author' => $request->input('author'),
                'content' => $request->input('content'),
            ]);

            return response()->json(["message" => "Blog created successfully", "status" => 201, "data" => $blog]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function show(Request $request)
    {
        try {
            // Use Eloquent's findOrFail to get a blog by its ID
            $blog = Blog::findOrFail($request->id);

            return response()->json(["data" => $blog, "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Blog not found.', "status" => 404]);
        }
    }

    public function update(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string',
                'blogImage' => 'nullable|mimes:jpg,png,jpeg',
                'author' => 'nullable|string',
                'content' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(["message" => "Validation failed", "errors" => $validator->errors(), "status" => 422]);
            }

            // Find the blog by its ID
            $blog = Blog::find($request->id);

            // Check if the blog exists
            if (!$blog) {
                return response()->json(["message" => "Blog not found", "status" => 404]);
            }

            // Update only changed fields
            $blog->title = $request->filled('title') ? $request->title : $blog->title;
            $blog->author = $request->filled('author') ? $request->author : $blog->author;
            $blog->content = $request->filled('content') ? $request->content : $blog->content;
            

            // Update blog image if a new one is provided
            if ($request->hasFile('blogImage')) {
                $blog->blogImage = $request->file('blogImage')->storeAs('blog_images', uniqid() . '_' . $request->file('blogImage')->getClientOriginalName());
            }

            // Save the updated blog
            $blog->save();

            return response()->json(["message" => "Blog updated successfully", "status" => 200, "data" => $blog]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something went wrong. ' . $e->getMessage(), "status" => 500]);
        }
    }


    public function destroy(Request $request)
    {
        try {
            // Get the blog ID from the request
            $blogId = $request->id;

            // Find the blog by its ID
            $blog = Blog::findOrFail($blogId);

            // Delete the blog
            $blog->delete();

            return response()->json(["message" => "Blog deleted successfully", "status" => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }
}
