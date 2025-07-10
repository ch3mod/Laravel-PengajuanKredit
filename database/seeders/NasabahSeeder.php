<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Nasabah;
use Faker\Factory as Faker;

class NasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) { // Misal kita buat 10 data
            Nasabah::create([
                'nama' => 'Nasabah ' . $i,
                'alamat' => 'Alamat ' . $i,
                'no_telepon' => '0812' . rand(10000000, 99999999),
                'no_ktp' => rand(1000000000000000, 9999999999999999),
                'no_registrasi' => $this->generateNoRegistrasi(),
                'bi_checking' => $faker->randomElement(['Lancar', 'Dalam Pengawasan Khusus', 'Kurang Lancar','Diragukan','Macet']),
            ]);
        }
    }

    /**
     * Generate unique no_registrasi.
     */
    private function generateNoRegistrasi(): string
    {
        do {
            $noRegistrasi = 'NR' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Nasabah::where('no_registrasi', $noRegistrasi)->exists());

        return $noRegistrasi;
    }
}
