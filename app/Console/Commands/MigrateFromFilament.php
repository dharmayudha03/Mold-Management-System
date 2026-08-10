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

        // STEP 1: MASTER DATA (Migrasikan tabel master terlebih dahulu dengan urutan dependensi yang benar)
        $this->info("\n--- [1/2] MEMINDAHKAN MASTER DATA ---");
        $this->migrateTable($sourceConnection, 'kategoris', 'kategoris', 'Master Kategori');
        $this->migrateTable($sourceConnection, 'list_code_items', 'list_code_items', 'Master List Code Item');
        $this->migrateTable($sourceConnection, 'set_code_items', 'set_code_items', 'Master Set Code Item');
        $this->migrateTable($sourceConnection, 'cav_code_items', 'cav_code_items', 'Master Cavity Code Item');
        
        // Parent Mesin (list_mesins) HARUS diimpor duluan sebelum child (name_mesins & class_mesins)!
        $this->migrateTable($sourceConnection, 'list_mesins', 'list_mesins', 'Master List Mesin');
        $this->migrateTable($sourceConnection, 'name_mesins', 'name_mesins', 'Master Nama Mesin');
        $this->migrateTable($sourceConnection, 'class_mesins', 'class_mesins', 'Master Class Mesin');
        
        $this->migrateTable($sourceConnection, 'list_raks', 'list_raks', 'Master List Rak');
        $this->migrateTable($sourceConnection, 'list_no_raks', 'list_no_raks', 'Master List No Rak');
        $this->migrateTable($sourceConnection, 'penomoran_raks', 'penomoran_raks', 'Master Penomoran Rak');
        $this->migrateTable($sourceConnection, 'detail_users', 'detail_users', 'Master Karyawan PIC');

        // STEP 2: TRANSAKSI & FORM REPORT DATA (Migrasikan data formulir)
        $this->info("\n--- [2/2] MEMINDAHKAN DATA TRANSAKSI & FORMULIR ---");
        $this->migrateTable($sourceConnection, 'form_schedules', 'form_schedules', 'Form Schedule');
        $this->migrateTable($sourceConnection, 'form_setup_cetakans', 'form_setup_cetakans', 'Form Setup Cetakan');
        $this->migrateTable($sourceConnection, 'form_sandblastings', 'form_sandblastings', 'Form Sandblasting');
        $this->migrateTable($sourceConnection, 'form_repair_cetakans', 'form_repair_cetakans', 'Form Repair Cetakan (PEJO)');
        $this->migrateTable($sourceConnection, 'form_mjos', 'form_mjos', 'Form MJO');
        $this->migrateTable($sourceConnection, 'cetakan_naiks', 'cetakan_naiks', 'Cetakan Naik');
        $this->migrateTable($sourceConnection, 'history_cetakans', 'history_cetakans', 'History Cetakan');

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
                    $bar->advance();
                }
            });

            $bar->finish();
            $this->newLine();
            $this->info("[+] BERHASIL: {$imported} record '{$label}' berhasil diimpor.");

            // Reset PostgreSQL sequence ID after batch insert
            $this->resetPgsqlSequence($targetTable);

        } catch (\Exception $e) {
            $this->error("\n[-] Gagal mengimpor {$label}: " . $e->getMessage());
        }
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
