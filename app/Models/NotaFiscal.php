<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaFiscal extends Model
{
    use HasFactory;

    protected $table = 'notafiscal';

    protected $fillable = [
        'user_id',
        'estabelecimento_id',
        'data_emissao',
        'valor_total'
    ];

    public function itensNotaFiscal()
    {
        return $this->hasMany(ItemNotaFiscal::class, 'nota_fiscal_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_id', 'id');
    }
}
