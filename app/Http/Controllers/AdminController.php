<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\logoutHelper;
use App\Helpers\Team\addTeam;
use App\Helpers\player\addPlayer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|exists:users,email",
            "password" => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "validation error",
                "message" => $validator->errors()
            ], 422);
        }

        try {
            if (Auth::guard('web')->attempt([
                "email" => $request->email,
                "password" => $request->password
            ])) {
                $user = User::where('email', $request->email)->first();
                return response()->json([
                    "message" => "login Successful",
                    "token" => $user->createToken($request->email)->plainTextToken
                ], 200);
            } else {
                return response()->json([
                    "message" => "incorrect credentials!"
                ], 422);
            }
        } catch (\Throwable $th) {
            // Log the exception details here
            return response()->json([
                "message" => "An internal error occurred. Please try again later."
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        return logoutHelper::logout_helper($request);
    }

    public function addTeam(Request $request)
    {
        return addTeam::add_team($request);
    }
    public function addPlayer(Request $request)
    {
        return addPlayer::add_player($request);
    }
}
