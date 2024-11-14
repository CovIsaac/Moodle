<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';
    protected $fillable = ['nombre', 'fecha_entrega', 'descripcion', 'grupo_id'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
