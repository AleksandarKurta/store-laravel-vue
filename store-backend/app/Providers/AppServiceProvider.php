<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProductImportServiceInterface;
use App\Services\FakeStoreProductImportService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductImportServiceInterface::class, FakeStoreProductImportService::class);
    }

    public function boot(): void
    {
        //
    }
}
