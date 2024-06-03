<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Team extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        "name","password","email","balance"
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function player():HasMany{
        return $this->hasMany(Player::class);
    }
    
    public function log():HasMany{
        return $this->hasMany(Log::class);
    }
}
