<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('petugas')->insert([
            'id_petugas' => "01",
            'nama_petugas' => "aji",
            'jabatan' => "dokter",
            'created_at' => now(),
            'updated_at' => now()

        ]);
    }
}
