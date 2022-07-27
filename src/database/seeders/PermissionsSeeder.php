<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('permissions')->insert([
            'id' => 1,
            'name' => 'Create',
            'created_at' => $now
        ]);
        DB::table('permissions')->insert([
            'id' => 2,
            'name' => 'Read',
            'created_at' => $now
        ]);
        DB::table('permissions')->insert([
            'id' => 3,
            'name' => 'Update',
            'created_at' => $now
        ]);
        DB::table('permissions')->insert([
            'id' => 4,
            'name' => 'Delete',
            'created_at' => $now
        ]);
    }
}
