<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    protected $table = 'habilidades';

    protected $fillable = [
        'user_id', 'nombre', 'descripcion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
