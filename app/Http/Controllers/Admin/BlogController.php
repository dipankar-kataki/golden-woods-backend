<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Traits\AjaxResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    use AjaxResponser;

    public function index(Request $request){
        if($request->isMethod('get')){
            return view('admin.blog.blog');
        }else{
            $validator = Validator::make($request->all(),[
                'blogTitle' => 'required',
                'blogImage' => 'required',
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

                    Blog::create([
                        'title' => $request->blogTitile,
                        'blogImage' => $file,
                        'content' => $request->blogContent
                    ]);

                    return $this->success('Great! Blog is created successfully', null, 200);

                }catch(\Exception $e){
                    return $this->error('Oops! Something went wrong.', null, 500);
                }
            }
            
        }
    }
}
