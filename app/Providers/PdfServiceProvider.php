<?php

namespace App\Providers;

use App\Interfaces\PdfGeneratorInterface;
use App\Services\DompdfGeneratorService;
use Illuminate\Support\ServiceProvider;

class PdfServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PdfGeneratorInterface::class, DompdfGeneratorService::class);
    }

    public function boot()
    {
        //
    }
}
