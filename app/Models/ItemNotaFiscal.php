<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemNotaFiscal extends Model
{
    use HasFactory;

    protected $table = 'itemnotafiscal';

    protected $primaryKey = 'item_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'item_id',
        'nota_fiscal_id',
        'produto_codigo',
        'quantidade',
        'valor_unitario',
        'valor_total'
    ];

    public function notaFiscal()
    {
        return $this->belongsTo(NotaFiscal::class, 'nota_fiscal_id', 'nota_fiscal_id');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_codigo', 'codigo');
    }
}
