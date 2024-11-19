<?php

namespace App\Services;

use App\Interfaces\PdfGeneratorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class DompdfGeneratorService implements PdfGeneratorInterface
{
    public function generate(string $view, array $data): string
    {
        $options = new Options;
        $options->set('defaultFont', 'Courier');

        $dompdf = new Dompdf($options);

        $html = view($view, $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
