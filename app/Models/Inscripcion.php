<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';
    protected $fillable = ['grupos_id', 'estudiantes_id', 'status'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupos_id', 'id');
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiantes_id', 'id');
    }
}
