<?php

namespace App\Console\Commands;

use App\Services\KBDataService;
use Illuminate\Console\Command;

class FetchKBDataFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kb:fetch-data {source?}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Fetch KB service data dari Free API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new KBDataService();
        $source = $this->argument('source') ?? 'randomuser';

        $this->info("Fetching KB data dari API: {$source}...");

        $result = match($source) {
            'randomuser' => $service->fetchFromPublicHealthAPI(),
            'who' => $service->fetchFromWHOAPI(),
            'indonesia' => $service->fetchFromIndonesiaHealthAPI(),
            'multiple' => $service->fetchFromMultipleSources(),
            default => ['success' => false, 'message' => 'Source tidak dikenali. Gunakan: randomuser, who, indonesia, atau multiple']
        };

        if ($result['success']) {
            $this->info('✓ ' . $result['message']);
        } else {
            $this->error('✗ ' . $result['message']);
        }

        return $result['success'] ? 0 : 1;
    }
}
