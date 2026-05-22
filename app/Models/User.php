<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'empresa_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    const ROLE_ADMIN = 'admin';
    const ROLE_EMPLEADO = 'empleado';
    const ROLE_EMPRESA = 'empresa';
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
    public function isEmpleado(): bool
    {
        return $this->role === self::ROLE_EMPLEADO;
    }
    public function isEmpresa(): bool
    {
        return $this->role === self::ROLE_EMPRESA;
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }

// Relación con la empresa (usuario que es su empresa)
    public function empresa()
    {
        return $this->belongsTo(User::class, 'empresa_id');
    }

// Relación con los empleados (si es una empresa)
    public function empleados()
    {
        return $this->hasMany(User::class, 'empresa_id');
    }
    public function formaciones()
    {
        return $this->hasMany(Formacion::class);
    }

    public function experiencias()
    {
        return $this->hasMany(Experiencia::class);
    }

    public function certificaciones()
    {
        return $this->hasMany(Certificacion::class);
    }

    public function habilidades()
    {
        return $this->hasMany(Habilidad::class);
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }
}
