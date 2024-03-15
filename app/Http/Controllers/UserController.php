<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use App\Models\ResetPassword;


class UserController extends Controller
{
    public function signup(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(["message" => 'Oops!' . $validator->errors()->first(), "status" => 400]);
            }
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
            $token = Auth::login($user);
            // $user->save();

            return response()->json(["data" => "Admin created successfully", "status" => 201, 'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]]);
        } catch (\Exception $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(["message" => "email already exists. Pleaese provide another email", "status" => 400]);
            } else {
                return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
            }
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["message" => 'Oops! ' . $validator->errors()->first(), "status" => 400]);
            }

            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials);
            if (!$token) {
                return response()->json(['message' => 'Invalid credentials', 'status' => 401]);
            }
            // If the credentials are correct, issue a Sanctum token
            //$user = Auth::guard('sanctum')->user();
            $user = Auth::user();
            // Issue a Sanctum token
            //$token = $user->createToken('api-token')->plainTextToken;

            return response()->json(['token' => $token, 'message' => 'Login successful', 'status' => 200]);

        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $email = $request->email;

            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json(['message' => 'Email not registered', 'status' => 404]);
            }

            $token = Str::random(20);

            $resetToken = ResetPassword::updateOrCreate(
                ['email' => $email],
                [
                    'token' => $token,
                    'expires_at' => now()->addMinutes(15),
                ]
            );

            Mail::to($email)->send(new ResetPasswordEmail($token));

            return response()->json(['token' => $token, 'message' => 'Please reset password using the sent link', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => 'Oops! Something Went Wrong.' . $e->getMessage(), "status" => 500]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors(), 'status' => 400]);
            }

            $email = $request->email;
            $token = $request->token;
            $password = $request->password;

            // Check if the reset token exists
            $resetToken = ResetPassword::where('email', $email)->where('token', $token)->first();

            if (!$resetToken) {
                return response()->json(['message' => 'Invalid reset token', 'status' => 404]);
            }

            // Check if the token has expired
            if ($resetToken->expires_at < now()) {
                return response()->json(['message' => 'Reset token has expired', 'status' => 400]);
            }

            // Find the user by email
            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json(['message' => 'User not found', 'status' => 404]);
            }

            // Update user's password
            $user->password = bcrypt($password);
            $user->save();

            // Delete the used reset token
            $resetToken->delete();

            return response()->json(['message' => 'Password reset successfully. Please login to continue', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops! Something Went Wrong.' . $e->getMessage(), 'status' => 500]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken(); // Get the JWT token from the request

            if ($token) {
                JWTAuth::invalidate($token); // Invalidate the token
            }

            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops! Something went wrong.' . $e->getMessage(), 'status' => 500]);
        }
    }


}
