<?php

namespace Database\Seeders;

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
    
    DB::table('users')->insert([
            'name' => "Septian Aji", 
            'email' => 'aji123@gmail.com',
            'password' => bcrypt('aa'),
            'level' => 'super_admin',
            'id_poli' => 1,
        ]);

        
   




    }
}
