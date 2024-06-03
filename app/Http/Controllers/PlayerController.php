<?php

namespace App\Http\Controllers;

use App\Helpers\Team\Bidding;
use App\Models\Log;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    //Add a frontend logic which will call this function's Api Acc to sir's demand (may be you'll need to use while loop. )
    public function getPlayerInfo($id)
    {
        $player = Player::where('id',$id)->get();
        return response()->json($player);
    }

    public function placeBid(Request $request)
    {   
        try {
            $team_max = Team::all()->count();
            $player_max = Player::all()->count();
            $validator = Validator::make($request->all(), [
                "bid" => "required|max:1500000|min:0|integer",
                "team_id" => "required|exists:teams,id|integer|min:2|max:$team_max",
                "player_id" => "required|exists:players,id|integer|min:1|max:$player_max"
            ],);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }
        
            $team = Team::find($request->team_id);
            
            if ($team->balance > $request->bid) {
                return Bidding::place_bid($request);
          
            } else {
                return response()
                    ->json([
                        'message' => 'Insufficient Balance'
                    ], 401);
            }
        }catch (\Throwable $th) {
            return response()->json([
                "error" => "SOmething is wrong on our end",
            ], 500);
        }
    }

    public function skipPlayer()
    {
        // Implement logic to skip player bidding (if needed)
        return response()->json(['message' => 'Player bidding skipped'], 200);
    }
}
