<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetsModel extends Model
{
    protected $table = 'tb_pets';

    protected $fillable = [
        'nome',
        'especie',
        'raca',
        'cor',
        'data_nascimento',
        'data_obito',
        'sexo',
        'personalidade',
        'observacoes',
        'animal_chipado',
        'numero_chip',
        'foto',
        'id_foto',
    ];

    public function tutores()
    {
        return $this->belongsToMany(
            User::class,
            'tb_user_pets',
            'pet_id',
            'user_id'
        );
    }

    public function peso()
    {
        return $this->hasMany(HistoricoPesoModel::class, 'pet_id');
    }
}
