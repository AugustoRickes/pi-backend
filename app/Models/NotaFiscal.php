<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaFiscal extends Model
{
    use HasFactory;

    protected $table = 'notafiscal';

    protected $primaryKey = 'nota_fiscal_id';

    public $incrementing = false;

    protected $fillable = [
        'nota_fiscal_id',
        'usuario_uuid',
        'estabelecimento_cnpj',
        'data_emissao',
        'valor_total'
    ];

    public function itens()
    {
        return $this->hasMany(ItemNotaFiscal::class, 'nota_fiscal_id', 'nota_fiscal_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_uuid', 'id');
    }
}
