<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'titre',
        'description',
        'statut',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'date' => 'date',
        'validated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
