<?php

namespace App\Helpers\Team;

use App\Models\Log;
use App\Models\Player;
use App\Models\Team;

class Bidding
{
    public static function place_bid($request)
    {
        $bidding_team = $request->team_id;
        $bidding_player = $request->player_id;
        $max_teams = Team::all()->count();

        if (
            Log::where('player_id', $bidding_player)
            ->where('team_id', $bidding_team)
            ->first() == null
        )  // To check if team has already bid for that player
        {

            if ($bidding_team == 2) {
                // If  first team is bidding for the player
                if (
                    Log::where('player_id', $bidding_player - 1)
                    ->where('team_id', $max_teams)
                    ->first() != null
                ) {
                    // check if previous player's bid is completed
                    if (
                        (($request->bid >  (int)Player::where('id', $bidding_player)
                            ->first('BasePrice')->toArray()['BasePrice'])) //This condition will ensure that bidder has not entered a lower value than current and base price of a player
                    ) {
                        return Bidding::store($request);
                    } else {
                        return response()->json([
                            "message" => "Amount should be greater than other team\baseprice or you can skip the player .Enter 0 as Bid to skip "
                        ], 200);
                    }
                } else {
                    return response()->json([
                        "message" => "Bidding is closed for now"
                    ], 401);
                }
            } else {
                if (
                    Log::where('player_id', $bidding_player)
                    ->where('team_id', $bidding_team - 1)
                    ->first() != null
                ) {
                    // checks if all previous teams has completed their bidding
                    if ($request->bid == 0 && $bidding_team != 4) {
                        Log::create($request->all());
                        return response()->json([
                            'message' => 'You have skipped that player'
                        ], 200);
                    }
                    if (
                        ($request->bid > (Log::where('player_id', $bidding_player)
                        ->where('team_id', $bidding_team - 1)
                        ->first('bid')->bid)) && (($request->bid >  (int)Player::where('id', $bidding_player)
                            ->first('BasePrice')->toArray()['BasePrice'])) //This condition will ensure that bidder has not entered a lower value than current or base price of a player
                    ) {
                        Bidding::store($request);
                    } //bidding logic
                    elseif ($request->bid != 0) {
                        return response()->json([
                            "message" => "Amount should be greater than other team or you can skip the player .Enter 0 as Bid to skip "
                        ], 200);
                    }
                    if ($bidding_team == Team::all()->count()) {

                        //Winner Logic with return statement
                        return Bidding::select_winner($request, $bidding_player);
                    }

                    return response()->json([
                        "message" => "Bid Placed Successfully"
                    ], 201);
                } else {
                    return response()->json([
                        "message" => "Bidding is closed for now"
                    ], 401);
                }
            }
        } else {
            return response()->json([
                "message" => "You have already bid"
            ], 200);
        }
    }


    //Function to place bid in Log table 
    public static function store($request)
    {
        Log::create($request->all()); //placing last team's bid
        return response()->json([
            "message" => "Bid Placed Successfully"
        ], 201);
    }

    //Function That will select a Winner
    public static function select_winner($request, $bidding_player)
    {
        $bids = [];
        $team_bid_array = Log::where('player_id', $bidding_player)->get(['team_id', 'bid'])->toArray(); //contains team and their bd for that particular player
        foreach ($team_bid_array as $team) {
            $bids[$team['team_id']] = $team['bid'];
        }
        if ($request->bid == 0) {
            Log::create($request->all());
        }
        $winner_team = array_search(max($bids), $bids);
        $winner_team_name = Team::where('id', $winner_team)->first('name')->toArray();

        $win_amount = max($bids);
        $winner = [
            'team_id' => $winner_team,
            'currentprice' => $win_amount
        ];
        Player::where('id', $bidding_player)->update($winner);

        //Debit from team's balance
        $team = Team::where('id', $winner['team_id'])->first();

        $new_balance = $team->balance - $request->bid;
        $team->update(['balance' => $new_balance]);

        $bids = [];
        return response()->json([
            "message" => "This Player is bhougth by {$winner_team_name['name']} for $   $win_amount"
        ], 200);
    }
}
