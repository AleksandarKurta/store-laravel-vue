<?php

namespace App\Providers;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\FakeStoreProductImportService;
use App\Services\Product\ProductImportServiceInterface;
use App\Services\Product\ProductUpdaterService;
use App\Services\Product\ProductUpdaterServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductImportServiceInterface::class, FakeStoreProductImportService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductUpdaterServiceInterface::class, ProductUpdaterService::class);
    }

    public function boot(): void
    {
        //
    }
}
