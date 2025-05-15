<?php

namespace App\Providers;

use App\Services\FakeStoreProductImportService;
use App\Services\ProductImportServiceInterface;
use Illuminate\Support\ServiceProvider;

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
