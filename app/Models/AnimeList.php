<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeList extends Model
{
    protected $table = 'anime_list';

    protected $fillable = [
        'user_id', 'title', 'genre', 'episodes', 'episodes_watched', 'status', 'rating', 'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
