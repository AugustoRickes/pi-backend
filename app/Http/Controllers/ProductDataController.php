<?php

namespace App\Http\Controllers;

use App\Models\Estabelecimento;
use App\Models\ItemNotaFiscal;
use App\Models\NotaFiscal;
use App\Models\Produto;
use App\Services\ProductDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        try {
            $productData = $this->productDataService->getProductDataFromTable($url);
            DB::transaction(function () use ($productData) {
                $cnpjLimpo = preg_replace('/[^0-9]/', '', $productData['empresa']['cnpj']);

                $estabelecimento = Estabelecimento::where('cnpj', $cnpjLimpo)->first();

                if (!$estabelecimento) {
                    $estabelecimento = Estabelecimento::create([
                        'cnpj' => $cnpjLimpo,
                        'nome' => $productData['empresa']['nome'] ?? 'sem nome',
                    ]);
                }
                $notaFiscal = NotaFiscal::create(

                    [
                        'user_id' => auth()->id(),
                        'estabelecimento_id' => $estabelecimento->id,
                        'data_emissao' => now(),
                        'valor_total' => $this->calculaTotal($productData['itens']),
                    ]
                );
//            dd($notaFiscal);
                foreach ($productData['itens'] as $item) {

                    $produto = Produto::firstOrCreate(
                        [
                            'nome' => $item['produto'],
                        ]
                    );

                    ItemNotaFiscal::create(
                        [
                            'nota_fiscal_id' => $notaFiscal->id,
                            'produto_id' => $produto->id,
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

    protected function calculaTotal(array $itens): float
    {
        return array_sum(array_column($itens, 'valTotal'));
    }
}
