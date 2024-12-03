<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('pasien')->insert([
        //     'nik_pasien' => "2011501620",
        //     'nama_pasien' => "Septian Aji", 
        //     'poli' => '1',
        //     'jenis_kelamin' => "laki-laki", 
        //     'tgl_lahir' => "2002-09-14", 
        //     // 'usia' => "23", 
        //     'alamat' => "jl.makam pari II", 
        //     'rt' => "02", 
        //     'rw' => "02", 
        //     'provinsi' => "DKI JAKARTA", 
        //     'kota' => "KOTA JAKARTA SELATAN", 
        //     'kecamatan' => "PESANGGRAHAN", 
        //     'kelurahan' => "PESANGGRAHAN", 
        //     'notelepon' => "081223844841", 
        //     'no_bpjs' => "13419109414", 
        //     'created_at' => now(), 
        //     'updated_at' => now(), 
           
        // ]);
        $faker = \Faker\Factory::create('id_ID');
        for($i=0; $i<10; $i++){
            Pasien::create([
                'nik_pasien' => $faker->unique()->numerify('############'),
                'nama_pasien' => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tgl_lahir' => $faker->date,
                'alamat' => $faker->address,
                'rt' => $faker->numberBetween(1, 15),
                'rw' => $faker->numberBetween(1, 15),
                'provinsi' => $faker->state,
                'kota' => $faker->city,
                'kecamatan' => $faker->city,
                'kelurahan' => $faker->city,
                'notelepon' => $faker->phoneNumber,
                'no_bpjs' => $faker->unique()->numerify('############'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
