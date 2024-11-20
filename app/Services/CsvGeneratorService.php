<?php

namespace App\Services;

use App\Interfaces\DocumentGeneratorInterface;

class CsvGeneratorService implements DocumentGeneratorInterface
{
    public function generate(string $view, array $data): string
    {
        $output = fopen('php://temp', 'r+');

        fputcsv($output, [
            __('order.order_id'),
            __('order.customer'),
            __('order.creation_date'),
            __('order.delivery_date'),]);
        fputcsv($output, [
            $data['order']->getId(),
            $data['order']->getUser()->getName(),
            $data['order']->getCreatedAt(),
            $data['order']->getDeliveryDate(),
        ]);

        fputcsv($output, []);

        fputcsv($output, [
            __('order.product'),
            __('order.quantity'),
            __('order.price'),]);

        foreach ($data['order']->itemInOrders as $item) {
            fputcsv($output, [
                $item->getType(),
                $item->getQuantity(),
                $item->getPrice(),
            ]);
        }

        fputcsv($output, []);
        fputcsv($output, [__('order.total'), '', $data['order']->getCustomTotalPrice()]);

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return $csvContent;
    }
}
