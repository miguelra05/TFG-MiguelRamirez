<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificacion extends Model
{
    protected $table = 'certificaciones';

    protected $fillable = [
        'user_id', 'nombre_emisor', 'titulo', 'fecha_obtencion', 'descripcion'
    ];

    protected $casts = [
        'fecha_obtencion' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
