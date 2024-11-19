<?php

namespace App\Services;

use App\Interfaces\DocumentGeneratorInterface;

class CsvGeneratorService implements DocumentGeneratorInterface
{
    public function generate(string $view, array $data): string
    {
        $output = fopen('php://temp', 'r+');

        // Encabezados del CSV
        fputcsv($output, ['Product', 'Quantity', 'Price']);

        // Itera sobre los ítems de la orden
        if (! empty($data['order']->itemInOrders)) {
            foreach ($data['order']->itemInOrders as $item) {
                fputcsv($output, [
                    $item->getType(),
                    $item->getQuantity(),
                    $item->getPrice(),
                ]);
            }
        } else {
            // Mensaje en caso de que no haya ítems
            fputcsv($output, ['No items found', '', '']);
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return $csvContent;
    }
}
