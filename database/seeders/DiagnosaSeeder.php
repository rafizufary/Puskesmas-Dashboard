<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiagnosaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diagnosa')->insert([
            'kode_diagnosa' => "001",
            'nama_diagnosa' => "pusing", 
        ]);
    }
}
