<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoPesoModel extends Model
{
    protected $table = 'tb_historico_peso';
    public $timestamps = false;

    protected $fillable = [
        'pet_id',
        'peso',
        'data_registro',
    ];

    public function pet()
    {
        return $this->belongsTo(PetsModel::class, 'pet_id');
    }
}
