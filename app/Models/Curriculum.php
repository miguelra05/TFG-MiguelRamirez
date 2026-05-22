<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curriculums';

    protected $fillable = [
        'user_id', 'titulo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formaciones()
    {
        return $this->belongsToMany(Formacion::class, 'curriculum_formacion');
    }

    public function experiencias()
    {
        return $this->belongsToMany(Experiencia::class, 'curriculum_experiencia');
    }

    public function certificaciones()
    {
        return $this->belongsToMany(Certificacion::class, 'curriculum_certificacion');
    }

    public function habilidades()
    {
        return $this->belongsToMany(Habilidad::class, 'curriculum_habilidad');
    }
}
