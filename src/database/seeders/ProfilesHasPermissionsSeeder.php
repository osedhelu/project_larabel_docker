<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        // BEGIN: Permisos de Administrador
        DB::table('profiles_has_permissions')->insert([
            'id' => 1,
            'profile_id' => 1,
            'permission_id' => 1,
            'created_at' => $now
        ]);
        DB::table('profiles_has_permissions')->insert([
            'id' => 2,
            'profile_id' => 1,
            'permission_id' => 2,
            'created_at' => $now
        ]);
        DB::table('profiles_has_permissions')->insert([
            'id' => 3,
            'profile_id' => 1,
            'permission_id' => 3,
            'created_at' => $now
        ]);
        DB::table('profiles_has_permissions')->insert([
            'id' => 4,
            'profile_id' => 1,
            'permission_id' => 4,
            'created_at' => $now
        ]);
        // END: Permisos de Administrador

        // BEGIN: Permisos de Usuario
        DB::table('profiles_has_permissions')->insert([
            'id' => 5,
            'profile_id' => 2,
            'permission_id' => 2,
            'created_at' => $now
        ]);
        // END: Permisos de Usuario
    }
}
