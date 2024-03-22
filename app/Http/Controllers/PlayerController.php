<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    //Add a frontend logic which will call this function's Api Acc to sir's demand (may be you'll need to use while loop. U can go like )
    public function getPlayerInfo($id)
    {
        $player = Player::find($id)->first();
        return response()->json($player);
    }

    public function placeBid(Request $request)
    {
        // try {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:players,id',
            "team_id" => "required|exists:teams,id|integer|min:2|max:4",
            "Currentprice" => "required|max:1500000|min:1|integer",
        ], [
            'team_id.unique' => 'You have already placed the bid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $player = Player::find($request->id);
        $team = Team::find($request->team_id);

        if ($request->Currentprice > $player->Currentprice) {

            if ($team->balance > $request->Currentprice) {

                $new_balance = $team->balance - $request->Currentprice;
                $team->update(['balance'=> $new_balance]);
                $player->update($validator->validated());

                return response()->json([
                    'message' => 'Bid placed successfully'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Insufficient Balance'
                ], 200);
            }
        } else {
            return response()->json(['message' => 'Bid amount Is equal to another team OR You can skip the player'], 422);
        }
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         "error" => "SOmething is wrong on our end",
        //     ], 500);
        // }
    }

    public function skipPlayer()
    {
        // Implement logic to skip player bidding (if needed)
        return response()->json(['message' => 'Player bidding skipped'], 200);
    }
}
