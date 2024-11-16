<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
//        'uuid',
//        'nome',
        'cidade',
        'estado',
        'localizacao',
        'tem_carro',
        'km_por_litro',
        'kudos',
    ];

    public function notasFiscais()
    {
        return $this->hasMany(NotaFiscal::class, 'usuario_uuid', 'uuid');
    }
}
