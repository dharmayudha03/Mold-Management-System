<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateFromFilament extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:from-filament 
                            {--source-db=filament_pgsql : Nama koneksi database Filament di config/database.php}
                            {--force : Paksa migrasi tanpa konfirmasi}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrasi otomatis data aktif dari database PostgreSQL Filament lama ke sistem baru';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("=================================================");
        $this->info("  TOOL MIGRASI DATA FILAMENT PABRIK -> SISTEM BARU");
        $this->info("=================================================");

        $sourceConnection = $this->option('source-db');

        // Check connection to source database
        try {
            $sourcePdo = DB::connection($sourceConnection)->getPdo();
            $this->info("[OK] Terhubung ke database Filament lama via koneksi '{$sourceConnection}'.");
        } catch (\Exception $e) {
            $this->error("[ERROR] Gagal terhubung ke database Filament lama!");
            $this->warn("Pesan Error: " . $e->getMessage());
            $this->warn("Pastikan Anda sudah mengonfigurasi database Filament di file .env:");
            $this->line("FILAMENT_DB_HOST=127.0.0.1");
            $this->line("FILAMENT_DB_PORT=5432");
            $this->line("FILAMENT_DB_DATABASE=nama_database_filament_lama");
            $this->line("FILAMENT_DB_USERNAME=postgres");
            $this->line("FILAMENT_DB_PASSWORD=password_postgres");
            return 1;
        }

        if (!$this->option('force') && !$this->confirm("Apakah Anda yakin ingin memulai migrasi data dari Filament lama ke database sistem baru ini?", true)) {
            $this->info("Migrasi dibatalkan.");
            return 0;
        }

        $this->info("\nMemulai proses migrasi data...");

        // 1. Migrate Form Setup Cetakan
        $this->migrateTable($sourceConnection, 'form_setup_cetakans', 'form_setup_cetakans', 'Form Setup Cetakan');

        // 2. Migrate Form Sandblasting
        $this->migrateTable($sourceConnection, 'form_sandblastings', 'form_sandblastings', 'Form Sandblasting');

        // 3. Migrate Form Repair Cetakan (PEJO)
        $this->migrateTable($sourceConnection, 'form_repair_cetakans', 'form_repair_cetakans', 'Form Repair Cetakan (PEJO)');

        // 4. Migrate Form Schedule
        $this->migrateTable($sourceConnection, 'form_schedules', 'form_schedules', 'Form Schedule');

        // 5. Migrate Form MJO
        $this->migrateTable($sourceConnection, 'form_mjos', 'form_mjos', 'Form MJO');

        $this->newLine();
        $this->info("=================================================");
        $this->info("  [SELESAI] MIGRASI DATA HAK PABRIK BERHASIL!");
        $this->info("=================================================");

        return 0;
    }

    private function migrateTable(string $sourceConnection, string $sourceTable, string $targetTable, string $label)
    {
        try {
            if (!DB::connection($sourceConnection)->getSchemaBuilder()->hasTable($sourceTable)) {
                $this->warn("[-] Tabel '{$sourceTable}' tidak ditemukan di DB Filament. Melewati {$label}.");
                return;
            }

            $sourceRows = DB::connection($sourceConnection)->table($sourceTable)->get();
            $total = $sourceRows->count();

            if ($total === 0) {
                $this->line("[i] Tabel '{$sourceTable}' kosong.");
                return;
            }

            $bar = $this->output->createProgressBar($total);
            $bar->start();

            $imported = 0;
            DB::transaction(function () use ($sourceRows, $targetTable, $bar, &$imported) {
                foreach ($sourceRows as $row) {
                    $data = (array) $row;
                    
                    // Ignore ID auto-increment conflict if already exists
                    if (isset($data['id'])) {
                        $exists = DB::table($targetTable)->where('id', $data['id'])->exists();
                        if ($exists) {
                            unset($data['id']);
                        }
                    }

                    DB::table($targetTable)->insert($data);
                    $imported++;
                    $bar->advance();
                }
            });

            $bar->finish();
            $this->newLine();
            $this->info("[+] BERHASIL: {$imported} record '{$label}' berhasil diimpor.");

        } catch (\Exception $e) {
            $this->error("\n[-] Gagal mengimpor {$label}: " . $e->getMessage());
        }
    }
}
