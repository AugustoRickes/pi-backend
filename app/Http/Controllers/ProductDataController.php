<?php

namespace App\Http\Controllers;

use App\Services\ProductDataService;
use Illuminate\Http\Request;

class ProductDataController extends Controller
{
    protected ProductDataService $productDataService;

    public function __construct(ProductDataService $productDataService)
    {
        $this->productDataService = $productDataService;
    }

    public function fetchProductData(): \Illuminate\Http\JsonResponse
    {
        $url = 'https://dfe-portal.svrs.rs.gov.br/Dfe/QrCodeNFce?p=43240804005894000163650050001987311648873390|2|1|2|1E4FBD566B548A07853BC940A17E153EE760D610';
        $productData = $this->productDataService->getProductDataFromTable($url);

        return response()->json($productData);
    }
}
