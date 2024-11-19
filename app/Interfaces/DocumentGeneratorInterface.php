<?php

namespace App\Interfaces;

interface DocumentGeneratorInterface
{
    public function generate(string $view, array $data): string;
}
