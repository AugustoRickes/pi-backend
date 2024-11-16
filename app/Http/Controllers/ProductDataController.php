<?php

namespace App\Http\Controllers;

use App\Models\ItemNotaFiscal;
use App\Models\NotaFiscal;
use App\Services\ProductDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductDataController extends Controller
{
    protected ProductDataService $productDataService;

    public function __construct(ProductDataService $productDataService)
    {
        $this->productDataService = $productDataService;
    }

    public function processProductData(Request $request): JsonResponse
    {
        $request->validate([
            'url' => [
                'required',
                'regex:/^https?:\/\/[a-zA-Z0-9\-\.]+(\:[0-9]+)?(\/[^\s]*)?$/'
            ],
        ]);

        $url = $request->input('url');
//        $url = 'https://dfe-portal.svrs.rs.gov.br/Dfe/QrCodeNFce?p=43240894846755000740651280000866771952778479|2|1|1|D3C1B1353C81074ECBEB1C4F326F83ABF59722DA';
        try {
            $productData = $this->productDataService->getProductDataFromTable($url);
//            dd($productData);

//            dd($request->user());
            DB::transaction(function () use ($productData) {
                $notaFiscal = NotaFiscal::create(
                    [
                        'user_id' => auth()->id(),
                        'estabelecimento_cnpj' => $productData['empresa']['cnpj'],
                        'data_emissao' => now(),
//                        'valor_total' => $productData['valor_total'], tem que calcular o valor total na NF? @alusio
                    ]
                );
//            dd($notaFiscal);
                foreach ($productData['itens'] as $item) {
                    ItemNotaFiscal::create(
                        [
                            'nota_fiscal_id' => $notaFiscal->id,
                            'produto_codigo' => $item['cod'],
                        
                            'quantidade' => $item['qtd'] ?? 0,
                            'valor_unitario' => $item['valUnit'] ?? 0,
                            'valor_total' => $item['valTotal'] ?? 0,
                        ]
                    );
                }
            });

            return response()->json(['message' => 'dados processados e armazenados no banco ok'], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'erro no processamento e armazenamento',
                'details' => $e->getMessage(),
            ], 500);

        }

    }
}
