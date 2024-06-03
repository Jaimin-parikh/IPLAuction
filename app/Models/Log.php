<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'player_id',
        'team_id',
        'bid'
    ];

    public function team():BelongsTo{
        return $this->belongsTo(Team::class);
    }
    public function player():BelongsTo{
        return $this->belongsTo(Player::class);
    }
}
