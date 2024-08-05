<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    // Defina o nome da tabela, caso não siga a convenção de nomes padrão
    protected $table = 'consultas';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'usuario_id',
        'pet_id',
        'sintomas',
        'data_atendimento',
        'turno',
        'medico_id',
        'status',
        'obs',
    ];

    // Defina as relações
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }
}
