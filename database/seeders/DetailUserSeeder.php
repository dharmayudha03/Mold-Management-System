<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DetailUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $setupMaintRole = Role::where('name', 'Setup & Maintenance')->first();
        $userRole       = Role::where('name', 'User')->first();
        $leaderRole     = Role::where('name', 'Leader')->first();
        $peRole         = Role::where('name', 'Pe')->first();
        $spvRole        = Role::where('name', 'Supervisor')->first();
        $ppicRole       = Role::whereIn('name', ['PPIC', 'Ppic'])->first();
        $msdRole        = Role::whereIn('name', ['Msd', 'MSD'])->first();
        $hatsumonoRole  = Role::where('name', 'Hatsumono')->first();

        $saId   = $superAdminRole ? $superAdminRole->id : 1;
        $smId   = $setupMaintRole ? $setupMaintRole->id : 2;
        $uId    = $userRole ? $userRole->id : 3;
        $lId    = $leaderRole ? $leaderRole->id : 4;
        $peId   = $peRole ? $peRole->id : 5;
        $spvId  = $spvRole ? $spvRole->id : 6;
        $ppId   = $ppicRole ? $ppicRole->id : 7;
        $msdId  = $msdRole ? $msdRole->id : 8;
        $hatsId = $hatsumonoRole ? $hatsumonoRole->id : 9;

        DB::table('detail_users')->insert([
            [
                'role_id' => $saId, 
                'name' => 'Dharmayudha',
            ],

            // Setup & Maintenance Operators
            ['role_id' => $smId, 'name' => 'Rohimah'],
            ['role_id' => $smId, 'name' => 'Benny'],
            ['role_id' => $smId, 'name' => 'Hariyanto'],
            ['role_id' => $smId, 'name' => 'Ullumudin'],
            ['role_id' => $smId, 'name' => 'Hirwanto'],
            ['role_id' => $smId, 'name' => 'Imam Prasetyo'],
            ['role_id' => $smId, 'name' => 'Nanang Hidayat'],
            ['role_id' => $smId, 'name' => 'M. Nurdin'],
            ['role_id' => $smId, 'name' => 'Asep Mulyadi'],

            // Supervisor Operators
            ['role_id' => $spvId, 'name' => 'Indra Gunawan'],
            ['role_id' => $spvId, 'name' => 'Ridwan'],
            ['role_id' => $spvId, 'name' => 'Suradiyanto'],
            ['role_id' => $spvId, 'name' => 'Dede Alamsyah'],

            // Leader Operators
            ['role_id' => $lId, 'name' => 'Cahyadi'],
            ['role_id' => $lId, 'name' => 'Suyatman'],
            ['role_id' => $lId, 'name' => 'Suwarsono'],
            ['role_id' => $lId, 'name' => 'Teguh Semedi'],
            ['role_id' => $lId, 'name' => 'Joko Sutrisno'],
            ['role_id' => $lId, 'name' => 'Didik Susanto'],

            // User
            ['role_id' => $uId, 'name' => 'Ari Mustofa'],

            // PE Operators
            ['role_id' => $peId, 'name' => 'Dodi Fadilla'],
            ['role_id' => $peId, 'name' => 'Tri Wahyu'],
            ['role_id' => $peId, 'name' => 'Nurfaizin'],
            ['role_id' => $peId, 'name' => 'Armando'],

            // PPIC Operator (Hanya Yudiana)
            ['role_id' => $ppId, 'name' => 'Yudiana'],

            // MSD Operator (Ali)
            ['role_id' => $msdId, 'name' => 'Ali'],

            // Hatsumono Operators (Sri Rejeki, Adelina Sagala)
            ['role_id' => $hatsId, 'name' => 'Sri Rejeki'],
            ['role_id' => $hatsId, 'name' => 'Adelina Sagala'],
        ]);
    }
}
