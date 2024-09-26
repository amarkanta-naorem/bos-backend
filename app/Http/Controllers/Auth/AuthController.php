<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use App\Services\AuthServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Administration Users Registration
    public function register(UserRegisterRequest $request, AuthServices $authServices)
    {
        try {
            DB::beginTransaction();
            $username = $authServices->generateUsername($request->input('first_name') . $request->input('last_name'));
            User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $username,
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'profile_picture' => $request->input('profile_picture'),
            ]);
            DB::commit();
            return response()->json([
                "message" => "User Registered Successful"
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return response()->json([
                'message' => 'Oops! Something went wrong. Please try again later.',
            ], 401);
        }
    }

    // Administration Users Login
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('Auth Token')->accessToken;
            Auth::login($user);
            return response()->json([
                'message' => 'Successfully Logged In',
                'bearer_token' => $token
            ], 201);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
