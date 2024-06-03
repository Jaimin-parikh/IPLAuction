<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;
    protected $fillable = ["name", "state", "Baseprice", "Currentprice", "team_id"];
    
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function log(): HasMany
    {
        return $this->hasMany(Log::class);
    }
}
