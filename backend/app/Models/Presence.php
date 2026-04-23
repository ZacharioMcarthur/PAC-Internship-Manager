<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    //
    protected $fillable = ['user_id', 'date', 'heure_arrivee', 'heure_depart', 'latitude', 'longitude', 'is_valid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
