<?php

namespace App\Providers;

use App\Interfaces\DocumentGeneratorInterface;
use App\Services\DompdfGeneratorService;
use App\Services\ExcelGeneratorService;
use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('pdf', function () {
            return new DompdfGeneratorService();
        });

        $this->app->bind('excel', function () {
            return new ExcelGeneratorService();
        });

        $this->app->bind(DocumentGeneratorInterface::class, function ($app, $params) {
            return $this->app->make($params['type']);
        });
    }

    public function boot()
    {
        //
    }
}