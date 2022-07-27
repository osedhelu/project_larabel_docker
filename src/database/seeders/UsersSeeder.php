<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            'identification'=> 'V00000009',
            'names'=>'SysAdmin',
            'last_names'=>'Admin',
            'email'=>'admin@sys.com',
            'state'=>'Activo',
            'password'=>bcrypt('ADMadm1234*#'),
            'date_c'=>$now,
            'profile_id'=> 1,
            'created_at' => $now
        ]);
        DB::table('users')->insert([
            'identification'=> 'V00000001',
            'names'=>'SysUser',
            'last_names'=>'User',
            'email'=>'user@sys.com',
            'state'=>'Activo',
            'password'=>bcrypt('11223344'),
            'date_c'=>$now,
            'profile_id'=> 2,
            'created_at' => $now
        ]);
        DB::table('users')->insert([
            'identification'=> 'V00000002',
            'names'=>'Pedro',
            'last_names'=>'Perez',
            'email'=>'pedro.perez@test.com',
            'state'=>'Activo',
            'password'=>bcrypt('pedro.perez'),
            'date_c'=>$now,
            'profile_id'=> 2,
            'created_at' => $now
        ]);
    }
}
