<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [];
        for ($i = 1; $i < 500; $i++) {
            $user = [
                'name' => 'user' . $i,
                'email' => 'email' . $i . '@gmail.com',
                'password' => bcrypt('12345678'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $array[] = $user;
        }
        DB::table('users')->insert($array);
    }
}
