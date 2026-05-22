<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    protected $table = 'formaciones';

    protected $fillable = [
        'user_id', 'institucion', 'titulo', 'fecha_inicio', 'fecha_fin', 'descripcion'
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
