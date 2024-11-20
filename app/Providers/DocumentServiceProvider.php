<?php

namespace App\Providers;

use App\Interfaces\DocumentGeneratorInterface;
use App\Services\PdfGeneratorService;
use App\Services\CsvGeneratorService;
use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('pdf.generator', function () {
            return new PdfGeneratorService();
        });

        $this->app->bind('csv.generator', function () {
            return new CsvGeneratorService();
        });

        $this->app->bind(DocumentGeneratorInterface::class, function ($app, $params) {
            if (isset($params['type'])) {
                if ($params['type'] === 'pdf') {
                    return $app->make('pdf.generator');
                } elseif ($params['type'] === 'csv') {
                    return $app->make('csv.generator');
                }
            }

            throw new \InvalidArgumentException('The "type" parameter is required to resolve DocumentGeneratorInterface.');
        });
    }

    public function boot()
    {
        //
    }
}
