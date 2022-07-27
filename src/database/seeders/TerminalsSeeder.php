<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TerminalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('terminals')->insert([
            'serial' => 'N300W123451',
            'vuelto' => 1,
            'reversoc2p' => 0,
            'status' => 'Habilitada',
            'password' => 'disglobal_asoc',
            'model_id' => 2,
            'mark_id' => 1,
            'branch_id' => 1,
            'affiliate_id' => 1
        ]);
        DB::table('terminals')->insert([
            'serial' => 'N300W123452',
            'vuelto' => 1,
            'reversoc2p' => 0,
            'status' => 'Habilitada',
            'password' => 'disglobal_asoc',
            'model_id' => 2,
            'mark_id' => 1,
            'branch_id' => 2,
            'affiliate_id' => 2
        ]);
        DB::table('terminals')->insert([
            'serial' => 'N300W123453',
            'vuelto' => 0,
            'reversoc2p' => 1,
            'status' => 'Habilitada',
            'password' => 'disglobal_asoc',
            'model_id' => 2,
            'mark_id' => 1,
            'branch_id' => 3,
            'affiliate_id' => 3
        ]);
        DB::table('terminals')->insert([
            'serial' => 'N300W123454',
            'vuelto' => 0,
            'reversoc2p' => 0,
            'status' => 'Habilitada',
            'password' => 'disglobal_asoc',
            'model_id' => 1,
            'mark_id' => 1,
            'branch_id' => 4,
            'affiliate_id' => 4
        ]);
        DB::table('terminals')->insert([
            'serial' => 'N300W123455',
            'vuelto' => 1,
            'reversoc2p' => 1,
            'status' => 'Habilitada',
            'password' => 'disglobal_asoc',
            'model_id' => 2,
            'mark_id' => 1,
            'branch_id' => 6,
            'affiliate_id' => 6
        ]);
    }
}
