<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('poli')->insert([
            'kode_poli' => "01",
            'nama_poli' => "pusing",
            'created_at' => now(),
            'updated_at' => now()

        ]);
    }
}
