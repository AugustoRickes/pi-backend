<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ProductDataService
{
    public function getProductDataFromTable($url): array
    {
        $response = Http::get($url);
        $htmlContent = $response->body();

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

        return $this->formatProductData($productData);
    }

    protected function formatProductData(array $productData): array
    {
        $formattedData = [];
        foreach ($productData as $table) {
            foreach ($table as $row) {
//                echo "Row value: " . $row[0] . "\n";
                if (count($row) >= 2) {
                    $item = [];
                    $info = explode(' ', $row[0]);
                    $item['produto'] = $this->getProductName($info);
                    $item['cod'] = $this->getValueFromPattern($row[0], '/Código:\s*(\d+)/');
                    $item['qtd'] = $this->getValueFromPattern($row[0],'/Qtde.:\s*(\d+(?:\.\d+)?)/');
                    $item['un'] = $this->getValueFromPattern($row[0],'/UN:\s*([A-Z]{2})/');
                    $valUnitRaw = $this->getValueFromPattern($row[0], '/Vl\.?\s*Unit\.?\s*:\s*(.*)/');
                    $item['valUnit'] = preg_replace('/[^0-9,.]/', '', $valUnitRaw);

                    $item['valTotal'] = $this->getValueFromPattern($row[1],'/Vl.\s*Total\s*([\d,.]+)/');

                    $formattedData['itens'][] = $item;

                }
            }
        }
        return $formattedData;
    }

    protected function getProductName($info)
    {
        return implode('', array_slice($info, 0, array_search('(Código:', $info)));
    }

    protected function getValueFromPattern($text, $pattern)
    {
        preg_match($pattern, $text, $matches);
        return $matches[1] ?? null;
    }
}
