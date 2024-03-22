<?php
namespace App\Helpers;

class logoutHelper{
    public static function logout_helper($request){

        try {
            //get a hold on user's current access token and delete that
            $request->user()->currentAccessToken()->delete();
            return response()->json(
                [
                    "message" => "logged out",
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "message" => "Something needs to be fix from our end",
                ],
                500
            );
        }
    } 
}