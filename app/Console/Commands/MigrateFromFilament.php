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

        // Disable foreign key checks during migration if driver is pgsql
        if (DB::getDriverName() === 'pgsql') {
            try {
                DB::statement("SET CONSTRAINTS ALL DEFERRED");
            } catch (\Exception $e) {}
        }

        // STEP 1: MASTER DATA (List Code Item, Set Code Item, Cav Code Item, List Mesin, Name Mesin, Class Mesin)
        $this->info("\n--- [1/2] MEMINDAHKAN MASTER DATA (CODE ITEM & MESIN) ---");
        $this->migrateTable($sourceConnection, 'list_code_items', 'list_code_items', 'Master List Code Item');
        $this->migrateTable($sourceConnection, 'set_code_items', 'set_code_items', 'Master Set Code Item');
        $this->migrateTable($sourceConnection, 'cav_code_items', 'cav_code_items', 'Master Cavity Code Item');
        
        // Parent Mesin (list_mesins) & Child (name_mesins, class_mesins)
        $this->migrateTable($sourceConnection, 'list_mesins', 'list_mesins', 'Master List Mesin');
        $this->migrateTable($sourceConnection, 'name_mesins', 'name_mesins', 'Master Nama Mesin');
        $this->migrateTable($sourceConnection, 'class_mesins', 'class_mesins', 'Master Class Mesin');

        // STEP 2: FORM SETUP CETAKAN & FORM SANDBLASTING
        $this->info("\n--- [2/2] MEMINDAHKAN FORM SETUP CETAKAN & FORM SANDBLASTING ---");
        $this->migrateTable($sourceConnection, 'form_setup_cetakans', 'form_setup_cetakans', 'Form Setup Cetakan');
        $this->migrateTable($sourceConnection, 'form_sandblastings', 'form_sandblastings', 'Form Sandblasting');
        
        // PIVOT RELASI PIC KARYAWAN (Detail User Forms)
        $this->migrateTable($sourceConnection, 'detail_user_form_setup_cetakan', 'detail_user_form_setup_cetakan', 'Relasi PIC Form Setup Cetakan');
        $this->migrateTable($sourceConnection, 'detail_user_form_sandblasting', 'detail_user_form_sandblasting', 'Relasi PIC Form Sandblasting');

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
            $skipped = 0;
            $itemIndex = 1;

            foreach ($sourceRows as $row) {
                $data = (array) $row;
                
                // Lewati data yatim piatu (orphan record) yang relasi foreign key-nya tidak ada di database target
                if (!$this->validateForeignKeys($targetTable, $data)) {
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                // Abaikan no document (nodoc) lama dari Filament, gunakan format standar sistem baru kita
                if ($targetTable === 'form_setup_cetakans') {
                    $recId = $data['id'] ?? $itemIndex;
                    $data['nodoc'] = 'DOC-SETUP' . str_pad($recId, 2, '0', STR_PAD_LEFT);
                } elseif ($targetTable === 'form_sandblastings') {
                    $recId = $data['id'] ?? $itemIndex;
                    $data['nodoc'] = 'DOC-SANDBLASTING' . str_pad($recId, 2, '0', STR_PAD_LEFT);
                }

                try {
                    // Upsert or insert with exact ID preservation
                    if (isset($data['id'])) {
                        $id = $data['id'];
                        $exists = DB::table($targetTable)->where('id', $id)->exists();
                        if ($exists) {
                            DB::table($targetTable)->where('id', $id)->update($data);
                        } else {
                            DB::table($targetTable)->insert($data);
                        }
                    } else {
                        DB::table($targetTable)->insert($data);
                    }
                    $imported++;
                } catch (\Exception $e) {
                    $skipped++;
                }

                $itemIndex++;
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            if ($skipped > 0) {
                $this->info("[+] BERHASIL: {$imported} record '{$label}' diimpor ({$skipped} data orphan dilewati).");
            } else {
                $this->info("[+] BERHASIL: {$imported} record '{$label}' berhasil diimpor.");
            }

            // Reset PostgreSQL sequence ID after batch insert
            $this->resetPgsqlSequence($targetTable);

        } catch (\Exception $e) {
            $this->error("\n[-] Gagal mengimpor {$label}: " . $e->getMessage());
        }
    }

    private function validateForeignKeys(string $targetTable, array $data): bool
    {
        $fkMaps = [
            'name_mesins' => ['list_mesin_id' => 'list_mesins'],
            'class_mesins' => ['list_mesin_id' => 'list_mesins'],
            'set_code_items' => ['list_code_item_id' => 'list_code_items'],
            'cav_code_items' => [
                'list_code_item_id' => 'list_code_items',
                'set_code_item_id' => 'set_code_items'
            ],
            'form_setup_cetakans' => [
                'list_code_item_id' => 'list_code_items',
                'set_code_item_id' => 'set_code_items',
                'cav_code_item_id' => 'cav_code_items',
                'list_mesin_id' => 'list_mesins',
                'kategori_id' => 'kategoris'
            ],
            'form_sandblastings' => [
                'list_code_item_id' => 'list_code_items',
                'set_code_item_id' => 'set_code_items',
                'cav_code_item_id' => 'cav_code_items',
                'list_mesin_id' => 'list_mesins',
                'kategori_id' => 'kategoris'
            ],
            'detail_user_form_setup_cetakan' => [
                'form_setup_cetakan_id' => 'form_setup_cetakans',
                'detail_user_id' => 'detail_users'
            ],
            'detail_user_form_sandblasting' => [
                'form_sandblasting_id' => 'form_sandblastings',
                'detail_user_id' => 'detail_users'
            ],
        ];

        if (!isset($fkMaps[$targetTable])) {
            return true;
        }

        foreach ($fkMaps[$targetTable] as $fkColumn => $parentTable) {
            if (isset($data[$fkColumn]) && !empty($data[$fkColumn])) {
                $exists = DB::table($parentTable)->where('id', $data[$fkColumn])->exists();
                if (!$exists) {
                    return false;
                }
            }
        }

        return true;
    }

    private function resetPgsqlSequence(string $table)
    {
        try {
            if (DB::getDriverName() === 'pgsql') {
                $maxId = DB::table($table)->max('id');
                if ($maxId) {
                    $seqName = "{$table}_id_seq";
                    DB::statement("SELECT setval('{$seqName}', {$maxId})");
                }
            }
        } catch (\Exception $e) {
            // Sequence reset optional fallback
        }
    }
}
