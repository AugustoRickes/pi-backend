<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductDataService
{
    public function getProductDataFromTable($url): array
    {
        $response = Http::get($url);
        $htmlContent = $response->body();

        $companyName = $this->getValueFromPattern($htmlContent, '/id="u20"\s*class="txtTopo">([^<]+)</');
        $cnpj = $this->getValueFromPattern($htmlContent, '/CNPJ:\s*([\d.\/-]+)/');

        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);

        $xpath = new \DOMXPath($dom);

        $tables = $xpath->query('//table');

        $productData = [];
        foreach ($tables as $table) {
            $rows = $xpath->query('.//tr', $table);
            $tableRows = [];
            foreach ($rows as $row) {
                $cells = $xpath->query('.//td', $row);
                $rowData = [];
                foreach ($cells as $cell) {
                    $text = trim($cell->textContent);
                    $cleanText = preg_replace('/\s+/', ' ', $text);
                    $cleanText = html_entity_decode($cleanText);
                    $rowData[] = $cleanText;
                }
                $tableRows[] = $rowData;
            }
            $productData[] = $tableRows;
        }

        return [
            'empresa' => [
                'nome' => $companyName,
                'cnpj' => $cnpj,
            ],
            'itens' => $this->formatProductData($productData),
        ];
    }

    protected function formatProductData(array $productData): array
    {
        $formattedData = [];
        foreach ($productData as $table) {
            foreach ($table as $row) {
                if (count($row) >= 2) {
                    $item = [];
                    $info = explode(' ', $row[0]);
                    $item['produto'] = $this->getProductName($info);
                    $item['cod'] = $this->getValueFromPattern($row[0], '/Código:\s*(\d+)/');
                    $item['qtd'] = $this->getValueFromPattern($row[0], '/Qtde.:\s*(\d+(?:\.\d+)?)/');
                    $item['un'] = $this->getValueFromPattern($row[0], '/UN:\s*([A-Z]{2})/');
                    $valUnitRaw = $this->getValueFromPattern($row[0], '/Vl\.?\s*Unit\.?\s*:\s*(.*)/');
                    $item['valUnit'] = preg_replace('/[^0-9,.]/', '', $valUnitRaw);

                    $item['valTotal'] = $this->getValueFromPattern($row[1], '/Vl.\s*Total\s*([\d,.]+)/');

                    $formattedData[] = $item;

                }
            }
        }

        return $formattedData;
    }

    protected function getProductName($info)
    {
        $index = array_search('(Código:', $info);
        if ($index === false) {
            return implode(' ', $info);
        }
        return implode(' ', array_slice($info, 0, $index));
    }

    protected function getValueFromPattern($text, $pattern)
    {
        preg_match($pattern, $text, $matches);
        return $matches[1] ?? null;
    }
}
