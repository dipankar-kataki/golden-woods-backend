<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Traits\AjaxResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    use AjaxResponser;

    public function index(Request $request){
        $all_blogs = Blog::orderBy('created_at', 'DESC')->get();
        return view('admin.blog.all')->with(['all_blogs' => $all_blogs]);
    }

    public function create(Request $request){
        if($request->isMethod('get')){
            return view('admin.blog.create');
        }else{
            $validator = Validator::make($request->all(),[
                'blogTitle' => 'required',
                'blogImage' => 'required|image|mimes:jpg,png,jpeg|2048',
                'blogContent' => 'required'
            ]);

            if($validator->fails()){
                return $this->error('Oops! '.$validator->errors()->first(), null, 400);
            }else{
                try{
                    $main_image = $request->blogImage;
                    $file = null;
                    if($request->hasFile('blogImage')){
                        $new_name = date('d-m-Y-H-i-s') . '_' . $main_image->getClientOriginalName();
                        $main_image->move(public_path('Blog/image/'), $new_name);
                        $file = 'Blog/image/' . $new_name;
                    }

                    if($request->blogId == null){
                        Blog::create([
                            'title' => $request->blogTitle,
                            'blogImage' => $file,
                            'content' => $request->blogContent
                        ]);
                        return $this->success('Great! Blog is created successfully', null, 200);
                    }else{

                        $get_image  = Blog::where('id', $request->blogId)->first();

                        if($main_image == null){
                            $file = $get_image->blogImage;
                        }

                        Blog::where('id', $request->blogId)->update([
                            'title' => $request->blogTitle,
                            'blogImage' => $file,
                            'content' => $request->blogContent
                        ]);

                        return $this->success('Great! Blog updated successfully', null, 200);
                    }

                    

                    

                }catch(\Exception $e){
                    return $this->error('Oops! Something went wrong.'.$e->getMessage(), null, 500);
                }
            }
            
        }
    }

    public function details($id){
        $get_details = Blog::where('id', $id)->first();
        return view('admin.blog.details')->with(['get_details' => $get_details]);
    }

    public function updateDetails(Request $request){
        try{
            $get_image  = Blog::where('id', $request->blogId)->first();
            $main_image = $request->blogImage;

            // return $this->success('Great! Blog updated successfully', $request->blogImage , 200);

            if($main_image == 'undefined'){
                $file = $get_image->blogImage;
            }else{
                $file = null;
                if($request->hasFile('blogImage')){
                    $new_name = date('d-m-Y-H-i-s') . '_' . $main_image->getClientOriginalName();
                    $main_image->move(public_path('Blog/image/'), $new_name);
                    $file = 'Blog/image/' . $new_name;
                }
            }

            Blog::where('id', $request->blogId)->update([
                'title' => $request->blogTitle,
                'blogImage' => $file,
                'content' => $request->blogContent
            ]);

            return $this->success('Great! Blog updated successfully', null, 200);

        }catch(\Exception $e){
            return $this->error('Oops! Something went wrong.'.$e->getMessage(), null, 500);
        }
    }

    public function delete(Request $request){
        Blog::where('id', $request->id)->delete();

        return $this->success("Great! Blog deleted successfully", 'deleted', 200);
    }
}
