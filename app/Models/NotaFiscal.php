<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaFiscal extends Model
{
    use HasFactory;

    protected $table = 'notafiscal';

//    protected $primaryKey = 'nota_fiscal_id';

//    public $incrementing = false;
//
//    protected $keyType = 'string';
//
//    public $timestamps = false;

    protected $fillable = [
//        'id',
        'user_id',
        'estabelecimento_cnpj',
        'data_emissao',
        'valor_total'
    ];

    public function itensNotaFiscal()
    {
        return $this->hasMany(ItemNotaFiscal::class, 'nota_fiscal_id', 'nota_fiscal_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class, 'estabelecimento_cnpj', 'cnpj');
    }
}
