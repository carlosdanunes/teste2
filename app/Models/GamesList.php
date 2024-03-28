<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GamesList extends Model
{
    use HasFactory;

     protected $table = 'games_list';

    protected $fillable = [
        'provider_code',
        'game_code',
        'game_name',
        'banner_url',
        'status',
        'opens',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function games_providers(): BelongsTo
    {
        return $this->belongsTo(GamesProviders::class, 'provider_code', 'provider_code');
    }
}
