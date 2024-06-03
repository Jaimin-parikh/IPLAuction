<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Helpers\logoutHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email|exists:teams,email",
                "password" => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => "validation error",
                    "message" => $validator->errors()
                ], 422);
            }
            $team =  Team::where('email', $request->email)->first();
            if (Hash::check($request->password, $team->password)) {
                return response()->json([
                    "message" => "login Successful",
                    "token" => $team->createToken($request->email, ['team'])->plainTextToken
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

}
