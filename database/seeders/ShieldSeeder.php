<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_form::sandblasting","view_any_form::sandblasting","create_form::sandblasting","update_form::sandblasting","view_form::setup::cetakan","view_any_form::setup::cetakan","create_form::setup::cetakan","update_form::setup::cetakan","view_penomoran::rak","view_any_penomoran::rak","update_form::schedule","view_form::schedule","view_any_form::schedule","view_form::repair::cetakan","view_any_form::repair::cetakan","create_form::repair::cetakan","update_form::repair::cetakan","publish_form::sandblasting","publish_form::setup::cetakan","publish_form::repair::cetakan","delete_form::sandblasting","delete_any_form::sandblasting","delete_form::setup::cetakan","delete_any_form::setup::cetakan","delete_form::repair::cetakan","delete_any_form::repair::cetakan","view_cav::code::item","view_any_cav::code::item","create_cav::code::item","update_cav::code::item","delete_cav::code::item","delete_any_cav::code::item","publish_cav::code::item","view_class::mesin","view_any_class::mesin","create_class::mesin","update_class::mesin","delete_class::mesin","delete_any_class::mesin","publish_class::mesin","view_code::item","view_any_code::item","create_code::item","update_code::item","delete_code::item","delete_any_code::item","publish_code::item","view_detail::user","view_any_detail::user","create_detail::user","update_detail::user","delete_detail::user","delete_any_detail::user","publish_detail::user","view_list::code::item","view_any_list::code::item","create_list::code::item","update_list::code::item","delete_list::code::item","delete_any_list::code::item","publish_list::code::item","view_list::mesin","view_any_list::mesin","create_list::mesin","update_list::mesin","delete_list::mesin","delete_any_list::mesin","publish_list::mesin","view_list::no::rak","view_any_list::no::rak","create_list::no::rak","update_list::no::rak","delete_list::no::rak","delete_any_list::no::rak","publish_list::no::rak","view_list::rak","view_any_list::rak","create_list::rak","update_list::rak","delete_list::rak","delete_any_list::rak","publish_list::rak","view_mesin","view_any_mesin","create_mesin","update_mesin","delete_mesin","delete_any_mesin","publish_mesin","view_name::mesin","view_any_name::mesin","create_name::mesin","update_name::mesin","delete_name::mesin","delete_any_name::mesin","publish_name::mesin","create_penomoran::rak","update_penomoran::rak","delete_penomoran::rak","delete_any_penomoran::rak","publish_penomoran::rak","view_proses::code::item","view_any_proses::code::item","create_proses::code::item","update_proses::code::item","delete_proses::code::item","delete_any_proses::code::item","publish_proses::code::item","view_set::code::item","view_any_set::code::item","create_set::code::item","update_set::code::item","delete_set::code::item","delete_any_set::code::item","publish_set::code::item","view_user","view_any_user","create_user","update_user","delete_user","delete_any_user","publish_user","view_cetakan::naik","view_any_cetakan::naik","create_cetakan::naik","update_cetakan::naik","publish_cetakan::naik","create_form::schedule","publish_form::schedule","view_history::cetakan","view_any_history::cetakan","delete_cetakan::naik","delete_any_cetakan::naik","delete_form::schedule","delete_any_form::schedule","create_history::cetakan","update_history::cetakan","delete_history::cetakan","delete_any_history::cetakan","publish_history::cetakan","view_kategori","view_any_kategori","create_kategori","update_kategori","delete_kategori","delete_any_kategori","publish_kategori","view_shield::role","view_any_shield::role","create_shield::role","update_shield::role","delete_shield::role","delete_any_shield::role"]},{"name":"Maintenance","guard_name":"web","permissions":["view_form::sandblasting","view_any_form::sandblasting","create_form::sandblasting","update_form::sandblasting","view_penomoran::rak","view_any_penomoran::rak","update_form::schedule","view_form::schedule","view_any_form::schedule","view_form::repair::cetakan","view_any_form::repair::cetakan","create_form::repair::cetakan","update_form::repair::cetakan"]},{"name":"Setup","guard_name":"web","permissions":["view_form::sandblasting","view_any_form::sandblasting","create_form::sandblasting","update_form::sandblasting","view_form::setup::cetakan","view_any_form::setup::cetakan","create_form::setup::cetakan","update_form::setup::cetakan","view_penomoran::rak","view_any_penomoran::rak","update_form::schedule","view_form::schedule","view_any_form::schedule"]},{"name":"User","guard_name":"web","permissions":["view_form::sandblasting","view_any_form::sandblasting","view_form::setup::cetakan","view_any_form::setup::cetakan","view_penomoran::rak","view_any_penomoran::rak","view_form::schedule","view_any_form::schedule","view_form::repair::cetakan","view_any_form::repair::cetakan","view_code::item","view_any_code::item","view_mesin","view_any_mesin","view_cetakan::naik","view_any_cetakan::naik","view_history::cetakan","view_any_history::cetakan","view_form::mjo","view_any_form::mjo"]},{"name":"Leader","guard_name":"web","permissions":["update_form::schedule","view_form::schedule","view_any_form::schedule","view_form::repair::cetakan","view_any_form::repair::cetakan","create_form::repair::cetakan","update_form::repair::cetakan","view_mesin","view_any_mesin","create_mesin","update_mesin","view_cetakan::naik","view_any_cetakan::naik","update_cetakan::naik","create_form::schedule"]},{"name":"Pe","guard_name":"web","permissions":["view_penomoran::rak","view_any_penomoran::rak","view_form::repair::cetakan","view_any_form::repair::cetakan","update_form::repair::cetakan","view_code::item","view_any_code::item","create_code::item","update_code::item","view_history::cetakan","view_any_history::cetakan","view_form::mjo","view_any_form::mjo","update_form::mjo","create_form::mjo"]},{"name":"Supervisor","guard_name":"web","permissions":["update_form::schedule","view_form::schedule","view_any_form::schedule","view_form::repair::cetakan","view_any_form::repair::cetakan","create_form::repair::cetakan","update_form::repair::cetakan","view_mesin","view_any_mesin","create_mesin","update_mesin","view_cetakan::naik","view_any_cetakan::naik","update_cetakan::naik","create_form::schedule"]},{"name":"PPIC","guard_name":"web","permissions":["update_form::schedule","view_form::schedule","view_any_form::schedule","view_cetakan::naik","view_any_cetakan::naik","create_form::schedule"]},{"name":"Msd","guard_name":"web","permissions":["view_form::mjo","view_any_form::mjo","update_form::mjo"]},{"name":"Hatsumono","guard_name":"web","permissions":["view_form::schedule","view_any_form::schedule","create_form::schedule"]}]';
        $directPermissions = '{"157":{"name":"view_role","guard_name":"web"},"158":{"name":"view_any_role","guard_name":"web"},"159":{"name":"create_role","guard_name":"web"},"160":{"name":"update_role","guard_name":"web"},"161":{"name":"delete_role","guard_name":"web"},"162":{"name":"delete_any_role","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
