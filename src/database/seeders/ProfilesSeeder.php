<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('profiles')->insert([
            'id' => 1,
            'name' => 'Administrador',
            'description' => 'admin@dis-global.com',
            'created_at' => $now
        ]);
        DB::table('profiles')->insert([
            'id' => 2,
            'name' => 'Usuario',
            'description' => 'user@dis-global.com',
            'created_at' => $now
        ]);
    }
}
