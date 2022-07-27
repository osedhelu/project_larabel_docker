<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('lists')->insert([
            'id' => 1,
            'name' => 'Marca',
            'created_at' => $now
        ]);
        DB::table('lists')->insert([
            'id' => 2,
            'name' => 'Modelo',
            'created_at' => $now
        ]);
    }
}
