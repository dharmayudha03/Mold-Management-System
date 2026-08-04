<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListRak;
use App\Models\ListNoRak;
use Illuminate\Support\Facades\DB;

class RakAndNoRakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder for RAK A through RAK Z, with No Rak 01 through 30 for each rack
        foreach (range('A', 'Z') as $char) {
            $rakName = "RAK " . $char;

            $rak = ListRak::firstOrCreate(
                ['rak' => $rakName]
            );

            for ($i = 1; $i <= 30; $i++) {
                $noRakStr = str_pad($i, 2, '0', STR_PAD_LEFT);

                ListNoRak::firstOrCreate(
                    [
                        'list_rak_id' => $rak->id,
                        'norak' => $noRakStr
                    ]
                );
            }
        }
    }
}
