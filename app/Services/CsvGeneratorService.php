<?php

namespace App\Services;

use App\Interfaces\DocumentGeneratorInterface;

class CsvGeneratorService implements DocumentGeneratorInterface
{
    public function generate(string $view, array $data): string
    {
        $output = fopen('php://temp', 'r+');

        // Escribe encabezados al archivo CSV
        fputcsv($output, ['Product', 'Quantity', 'Price']);

        foreach ($data['order']->items as $item) {
            fputcsv($output, [$item->name, $item->quantity, $item->price]);
        }

        // Agrega una fila con el total
        fputcsv($output, []);
        fputcsv($output, ['Total', '', $data['order']->total_price]);

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return $csvContent;
    }
}
