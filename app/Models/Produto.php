<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produto';

    protected $primaryKey = 'codigo';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'codigo',
        'nome',
        'marca',
    ];

    public function itensNotaFiscal()
    {
        return $this->hasMany(ItemNotaFiscal::class, 'produto_codigo', 'codigo');
    }
}
