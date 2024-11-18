<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model
{
    use HasFactory;

    protected $table = 'estabelecimento';

    protected $fillable = [
        'cnpj',
        'nome',
        'razao_social',
        'endereco',
        'cidade',
        'estado',
        'latitude',
        'longitude'
    ];


    public function notasFiscais()
    {
        return $this->hasMany(NotaFiscal::class, 'estabelecimento_id', 'id');
    }
}
