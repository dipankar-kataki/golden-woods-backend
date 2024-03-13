<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AjaxResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AjaxResponser;
    public function login(Request $request){
        if($request->isMethod('get')){
            return view('admin.auth.login');
        }else{
            try{
                $validator = Validator::make($request->all(),[
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

                if($validator->fails()){
                    return $this->error('Oops! '.$validator->errors()->first(), null, 400);
                }else{
                    if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                        return $this->error('Oops! Invalid credentials', null, 400);
                    }else{
                        return $this->success('Great! Sign in successful', '/admin/dashboard', 200);
                    }
                }

            }catch(\Exception $e){
                return $this->error('Oops! Something went wrong.', null, 500);
            }
        }
    }
}
