<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'user_id',
        'titulo',
        'tipo_documento',
        'ruta',
        'fecha_subida',
        'visibilidad'
    ];

    protected $casts = [
        'fecha_subida' => 'date',
        'visibilidad' => 'string',
    ];

    /**
     * Relación con el usuario propietario del documento
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verificar si el documento es público
     */
    public function isPublic(): bool
    {
        return $this->visibilidad === 'public';
    }

    /**
     * Verificar si el documento es privado
     */
    public function isPrivate(): bool
    {
        return $this->visibilidad === 'private';
    }

    /**
     * Obtener la extensión del archivo
     */
    public function getExtensionAttribute(): string
    {
        return $this->tipo_documento;
    }

    /**
     * Obtener el nombre del archivo (sin ruta)
     */
    public function getFilenameAttribute(): string
    {
        return basename($this->ruta);
    }

    /**
     * Obtener la URL de descarga
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('portfolio.download', $this);
    }

    /**
     * Obtener la URL pública (sin autenticación)
     */
    public function getPublicUrlAttribute(): string
    {
        return route('portfolio.public', $this);
    }
}
