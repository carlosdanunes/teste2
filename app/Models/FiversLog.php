<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiversLog extends Model
{
    use HasFactory;

    protected $table = 'fivers_logs';
    
    protected $fillable = [
        'game_id',
        'user_id',
        'token',
        'method',
        'amount',
    ];
    
    public function user (): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function game (): BelongsTo
    {
        return $this->belongsTo(GamesList::class);
    }
    
    public function provider (): BelongsTo
    {
        return $this->belongsTo(GamesProviders::class);
    }
}
