<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    // Los campos que se pueden llenar masivamente
    protected $fillable = [
        'title',
        'start',
        'end',
        'user_id',
        'ubicacion',
        'detalles_evento',
        'estado_evento',
        'color_evento',
        'notificacion',
        'mora'
    ];

    // Los campos que se deben castear a tipos nativos
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'notificacion' => 'boolean',
    ];

    // Relación: Un evento pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
