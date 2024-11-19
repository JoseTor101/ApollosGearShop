<?php

namespace App\Services;

use App\Interfaces\DocumentGeneratorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGeneratorService implements DocumentGeneratorInterface
{
    public function generate(string $view, array $data): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Courier');

        $dompdf = new Dompdf($options);
        $html = view($view, $data)->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}