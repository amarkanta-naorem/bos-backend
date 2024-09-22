<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\AuthServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
}
