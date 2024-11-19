<?php

namespace App\Interfaces;

interface PdfGeneratorInterface
{
    public function generate(string $view, array $data): string;
}
