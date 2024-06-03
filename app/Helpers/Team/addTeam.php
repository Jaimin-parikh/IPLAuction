<?php

namespace App\Helpers\Team;

use App\Helpers\PasswordValidator;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;

class addTeam
{
    public static function add_team($request)
    {
        try {
        $passValidation = PasswordValidator::rules();
        $validator = Validator::make($request->all(), [
            "name" => "required|alpha:ascii|unique:teams,name",
            "email" => "required|email|unique:teams,email",
            "password" => $passValidation
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "validation Error",
                "errors" => $validator->errors()
            ], 422);
        } else {
            if (Team::create($request->all()))
                return response()->json([
                    "message" => "team Created successfully!!"
                ], 200);
        }
        } catch (\Throwable $th) {
        return response()->json([
            "messsage" => "something is wrong from our end"
        ], 500);
        }
    }
}
