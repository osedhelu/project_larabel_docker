<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('branches')->insert([
            'name'=> 'Sucursal Admin',
            'location'=> 'Venezuela',
            'branch_type'=> 'P',
            'commerce_id' =>1,
            'created_at' => $now
        ]);
        DB::table('branches')->insert([
            'name'=> 'Sucursal User',
            'location'=> 'Venezuela Comercio 2',
            'branch_type'=> 'P',
            'commerce_id' =>2,
            'created_at' => $now
        ]);
        DB::table('branches')->insert([
            'name'=> 'Sucursal User',
            'location'=> 'Venezuela Comercio 2',
            'branch_type'=> 'P',
            'commerce_id' =>2,
            'created_at' => $now
        ]);
        DB::table('branches')->insert([
            'name'=> 'Sucursal User',
            'location'=> 'Venezuela Comercio 3',
            'branch_type'=> 'P',
            'commerce_id' =>3,
            'created_at' => $now
        ]);
        DB::table('branches')->insert([
            'name'=> 'Sucursal User',
            'location'=> 'Venezuela Comercio 3',
            'branch_type'=> 'P',
            'commerce_id' =>3,
            'created_at' => $now,
            'deleted_at' => $now
        ]);
        DB::table('branches')->insert([
            'name'=> 'Sucursal Pedro',
            'location'=> 'Venezuela Comercio 4',
            'branch_type'=> 'P',
            'commerce_id' =>4,
            'created_at' => $now
        ]);
    }
}
