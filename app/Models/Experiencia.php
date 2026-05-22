<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    protected $table = 'experiencias';

    protected $fillable = [
        'user_id', 'empresa', 'puesto', 'fecha_inicio', 'fecha_fin', 'descripcion'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
