<?php

namespace App\Helpers\player;

use App\Models\Player;
use Illuminate\Support\Facades\Validator;

class addPlayer
{
    public static function add_player($request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|alpha:ascii|unique:players,name",
            "state" => "required|alpha:ascii",
            "Baseprice" => "required|numeric",
            "Currentprice" => "required|numeric",
            "team_id" => "numeric|digits:1",
        ]);
        try {
            if ($validator->fails())
                return response()->json([
                    "message" => "validation Error",
                    "errors" => $validator->errors()
                ], 422);
            else {
                if (Player::create($request->all()))
                    return response()->json([
                        "message" => "Player Added successfully!!"
                    ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "messsage" => "something is wrong from our end"
            ], 500);
        }
    }
}
