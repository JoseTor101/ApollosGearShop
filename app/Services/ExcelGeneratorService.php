<?php

namespace App\Services;

use App\Interfaces\DocumentGeneratorInterface;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelGeneratorService implements DocumentGeneratorInterface, FromView
{
    private $view;
    private $data;

    public function generate(string $view, array $data): string
    {
        $this->view = $view;
        $this->data = $data;

        // Genera y retorna el archivo Excel como una cadena
        return Excel::download($this, 'export.xlsx')->getContent();
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view($this->view, $this->data);
    }
}
