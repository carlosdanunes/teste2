<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GamesProviders extends Model
{
    use HasFactory;

    protected $table = "provider_list";

    protected $fillable = [
        'provider_code',
        'provider_name',
        'type',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function games(): HasMany
    {
        return $this->hasMany(GamesList::class, 'provider_code', 'provider_code');
    }
}
