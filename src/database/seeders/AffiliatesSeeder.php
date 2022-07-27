<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffiliatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('affiliates')->insert([
            'affiliate' => 'Afiliados Admin',
            'commerce_id' => '1',
            'created_at' => $now
        ]);
        DB::table('affiliates')->insert([
            'affiliate' => 'Afiliados User 1',
            'commerce_id' => '2',
            'created_at' => $now
        ]);
        DB::table('affiliates')->insert([
            'affiliate' => 'Afiliados User 2',
            'commerce_id' => '2',
            'created_at' => $now
        ]);
        DB::table('affiliates')->insert([
            'affiliate' => 'Afiliados User 3',
            'commerce_id' => '3',
            'created_at' => $now
        ]);
        DB::table('affiliates')->insert([
            'affiliate' => 'Afiliados User 4',
            'commerce_id' => '3',
            'created_at' => $now,
            'deleted_at' => $now
        ]);
        DB::table('affiliates')->insert([
            'affiliate' => 'Afiliados Pedro',
            'commerce_id' => '4',
            'created_at' => $now
        ]);
    }
}
