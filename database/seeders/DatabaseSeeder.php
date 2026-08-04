<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed permissions first
        // $this->seedPermissions();

        // Seed users and roles
        $this->seedUsers();

        // Call additional seeders
        $this->callSeeders();
    }

    private function seedUsers(): void
    {
        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'Setup & Maintenance']);
        Role::firstOrCreate(['name' => 'User']);
        Role::firstOrCreate(['name' => 'Leader']);
        Role::firstOrCreate(['name' => 'Pe']);
        Role::firstOrCreate(['name' => 'Supervisor']);
        Role::firstOrCreate(['name' => 'PPIC']);
        Role::firstOrCreate(['name' => 'Msd']);
        Role::firstOrCreate(['name' => 'Hatsumono']);

        // Create admin user
        $admin = \App\Models\User::factory()->create([
            'name' => 'Dharmayudha',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
        $admin->assignRole('super_admin');

        // Create Setup & Maintenance user
        $setupMaint = \App\Models\User::factory()->create([
            'name' => 'Setup & Maintenance',
            'email' => 'setup@setup.com',
            'password' => bcrypt('setup'),
        ]);
        $setupMaint->assignRole('Setup & Maintenance');

        $leader = \App\Models\User::factory()->create([
            'name' => 'Leader',
            'email' => 'leader@leader.com',
            'password' => bcrypt('leader'),
        ]);
        $leader->assignRole('Leader');

        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('user'),
        ]);
        $user->assignRole('User');

        $pe = \App\Models\User::factory()->create([
            'name' => 'Production Engineering',
            'email' => 'pe@pe.com',
            'password' => bcrypt('pe'),
        ]);
        $pe->assignRole('Pe');

        $spv = \App\Models\User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@supervisor.com',
            'password' => bcrypt('spv'),
        ]);
        $spv->assignRole('Supervisor');

        $ppic = \App\Models\User::factory()->create([
            'name' => 'PPIC',
            'email' => 'ppic@ppic.com',
            'password' => bcrypt('ppic'),
        ]);
        $ppic->assignRole('PPIC');

        $moldshop = \App\Models\User::factory()->create([
            'name' => 'MoldShop',
            'email' => 'moldshop@moldshop.com',
            'password' => bcrypt('msd'),
        ]);
        $moldshop->assignRole('Msd');

        $hatsumono = \App\Models\User::factory()->create([
            'name' => 'Hatsumono',
            'email' => 'hatsumono@hatsumono.com',
            'password' => bcrypt('hatsumono'),
        ]);
        $hatsumono->assignRole('Hatsumono');
    }

    /**
     * Call additional seeders.
     */
    private function callSeeders(): void
    {
        $this->call([
            ShieldSeeder::class,
            ListCodeItemSeeder::class,
            SetCodeItemSeeder::class,
            CavCodeItemSeeder::class,
            CodeItemSeeder::class,
            ListMesinSeeder::class,
            NameMesinSeeder::class,
            ClassMesinSeeder::class,
            MesinSeeder::class,
            RakAndNoRakSeeder::class,
            KategoriSeeder::class,
            DetailUserSeeder::class,
            CetakanNaikSeeder::class,
            // FormSandblastingSeeder::class,
            // FormSetupCetakanSeeder::class,
            // DetailUserFormSandblastingSeeder::class,
            // DetailUserFormSetupCetakanSeeder::class,
        ]);
    }
}
