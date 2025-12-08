<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Site;
use Illuminate\Support\Facades\Http;

class CheckSitesStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sites:check {--id= : ID del sitio específico a verificar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el estado de todos los sitios activos o un sitio específico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $siteId = $this->option('id');

        if ($siteId) {
            $site = Site::find($siteId);
            if (!$site) {
                $this->error("Sitio con ID {$siteId} no encontrado");
                return 1;
            }
            $sites = collect([$site]);
        } else {
            $sites = Site::active()->get();
        }

        if ($sites->isEmpty()) {
            $this->info('No hay sitios activos para verificar');
            return 0;
        }

        $this->info("Verificando " . $sites->count() . " sitio(s)...\n");

        $bar = $this->output->createProgressBar($sites->count());
        $bar->start();

        $results = [
            'up' => 0,
            'down' => 0,
            'total' => $sites->count(),
        ];

        foreach ($sites as $site) {
            $this->checkSite($site, $results);
            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);
        $this->info("=== Resumen de Verificación ===");
        $this->line("Total verificados: {$results['total']}");
        $this->line("<fg=green>✓ Operativos: {$results['up']}</>");
        $this->line("<fg=red>✗ Caídos: {$results['down']}</>");

        return 0;
    }

    private function checkSite(Site $site, array &$results): void
    {
        try {
            $start = microtime(true);
            $response = Http::withOptions([
                'verify' => false, // Deshabilitar verificación SSL en desarrollo
            ])->timeout(10)->get($site->url);
            $responseTime = round((microtime(true) - $start) * 1000);

            if ($response->successful()) {
                $site->update([
                    'status' => 'up',
                    'response_time' => $responseTime,
                    'last_checked_at' => now(),
                ]);
                $results['up']++;
            } else {
                $site->update([
                    'status' => 'down',
                    'response_time' => $responseTime,
                    'last_checked_at' => now(),
                ]);
                $results['down']++;
            }
        } catch (\Exception $e) {
            $site->update([
                'status' => 'down',
                'response_time' => null,
                'last_checked_at' => now(),
            ]);
            $results['down']++;
        }
    }
}

