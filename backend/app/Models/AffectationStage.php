<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffectationStage extends Model
{
    protected $fillable = [
        'user_id',
        'departement_id',
        'maitre_stage_id',
        'date_debut',
        'date_fin',
    ];

    public function stagiaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function maitreStage()
    {
        return $this->belongsTo(User::class, 'maitre_stage_id');
    }
}
