<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommercesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('commerces')->insert([
            'name'=> 'Comercio Admin',
            'rif'=> 'J123456787',
            'email'=> 'asociados.disglobal@test.com',
            'phone'=> '2128884545',
            'password'=> 'asoc.disglobal',
            'user_id'=> 1,
            'created_at' => $now
        ]);
        DB::table('commerces')->insert([
            'name'=> 'Comercio User',
            'rif'=> 'J123456788',
            'email'=> 'comercio_user_1@test.com',
            'phone'=> '2128884546',
            'password'=> 'asoc.disglobal',
            'user_id'=> 2,
            'created_at' => $now
        ]);
        DB::table('commerces')->insert([
            'name'=> 'Comercio User',
            'rif'=> 'J123456789',
            'email'=> 'comercio_user_2@test.com',
            'phone'=> '2128884547',
            'password'=> 'asoc.disglobal',
            'user_id'=> 2,
            'created_at' => $now
        ]);
        DB::table('commerces')->insert([
            'name'=> 'Comercio Pedro',
            'rif'=> 'J123456789',
            'email'=> 'comercio_pedro@test.com',
            'phone'=> '2128884547',
            'password'=> 'asoc.disglobal',
            'user_id'=> 3,
            'created_at' => $now
        ]);
    }
}
