<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('det_lists')->insert([
            'id' => 1,
            'name' => 'Nexgo',
            'list_id' => '1',
            'created_at' => $now
        ]);
        DB::table('det_lists')->insert([
            'id' => 2,
            'name' => 'N3',
            'list_id' => '2',
            'created_at' => $now
        ]);
        DB::table('det_lists')->insert([
            'id' => 3,
            'name' => 'N5',
            'list_id' => '2',
            'created_at' => $now
        ]);
    }
}
