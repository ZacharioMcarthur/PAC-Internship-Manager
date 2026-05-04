<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'heure_arrivee',
        'heure_depart',
        'latitude',
        'longitude',
        'is_valid',
    ];

    protected $casts = [
        'date' => 'date',
        'heure_arrivee' => 'datetime:H:i:s',
        'heure_depart' => 'datetime:H:i:s',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_valid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
