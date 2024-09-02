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
                $formattedRow = [];
                foreach ($row as $cell) {
                    $formattedRow[] = $cell;
                }
                $formattedData[] = $formattedRow;
            }
        }
        return $formattedData;
    }
}
