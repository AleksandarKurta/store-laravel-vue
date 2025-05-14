<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductImportServiceInterface;

class ImportFakeStoreProducts extends Command
{
    protected $signature = 'import:fake-store-products {--fresh : Delete all existing products before import}';
    protected $description = 'Import products from Fake Store API into the local database';

    protected ProductImportServiceInterface $importService;

    public function __construct(ProductImportServiceInterface $importService)
    {
        parent::__construct();
        $this->importService = $importService;
    }

    public function handle()
    {
        $this->info('Fetching products from Fake Store API...');

        try {
            $productTitles = $this->importService->import($this->option('fresh'));

            foreach ($productTitles as $title) {
                $this->line("Imported: {$title}");
            }

            $this->info('Import completed successfully.');
        } catch (\Exception $e) {
            $this->error("Error: {$e->getMessage()}");
            return 1;
        }

        return 0;
    }
}
