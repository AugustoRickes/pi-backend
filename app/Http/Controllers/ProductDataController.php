<?php

namespace App\Http\Controllers;

use App\Services\ProductDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductDataController extends Controller
{
    protected ProductDataService $productDataService;

    public function __construct(ProductDataService $productDataService)
    {
        $this->productDataService = $productDataService;
    }

    public function fetchProductData(): JsonResponse
    {
        // URLS para testar
        // https://www.sefaz.rs.gov.br/NFCE/NFCE-COM.aspx?p=43240894846755000740651280000866771952778479|2|1|1|D3C1B1353C81074ECBEB1C4F326F83ABF59722DA

        // https://www.sefaz.rs.gov.br/NFCE/NFCE-COM.aspx?p=43240824033518000190651050000979591105779678|2|1|1|4065753AC639EED0C5DD9D7378126813E37E1BCA

        // https://www.sefaz.rs.gov.br/NFCE/NFCE-COM.aspx?p=43240804005894000163650050001987311648873390|2|1|2|1E4FBD566B548A07853BC940A17E153EE760D610

        $url = 'https://www.sefaz.rs.gov.br/NFCE/NFCE-COM.aspx?p=43240894846755000740651280000866771952778479|2|1|1|D3C1B1353C81074ECBEB1C4F326F83ABF59722DA';
        $productData = $this->productDataService->getProductDataFromTable($url);

        return response()->json($productData);
    }
}
