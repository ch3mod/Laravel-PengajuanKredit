<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PengajuanKreditSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil hanya nasabah dengan BI Checking "Lancar" atau "Dalam Pengawasan Khusus"
        $nasabahValid = DB::table('nasabah')
            ->whereIn('bi_checking', ['Lancar', 'Dalam Pengawasan Khusus'])
            ->pluck('id')
            ->toArray();

        // Jika tidak ada nasabah yang memenuhi syarat, hentikan seeding
        if (empty($nasabahValid)) {
            echo "Tidak ada nasabah yang memenuhi syarat untuk pengajuan kredit.\n";
            return;
        }

        // Ambil product_id untuk produk "silantap"
        $silantap = DB::table('products')->where('name', 'silantap')->value('id');

        // Jika produk "silantap" tidak ditemukan, hentikan seeding
        if (!$silantap) {
            echo "Produk 'silantap' tidak ditemukan.\n";
            return;
        }

        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            $data[] = [
                'nasabah_id' => $faker->randomElement($nasabahValid), // Pilih hanya nasabah yang valid
                 'product_id' => $silantap,
                'tanggal_pengajuan' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'jaminan' => $faker->randomElement(['SK Kontrak', 'Ijazah']),
                'jumlah_tanggungan' => $faker->numberBetween(2, 15),
                'jumlah_pemasukan' => $faker->randomFloat(2, 1000000, 10000000),
                'jumlah_pengeluaran' => $faker->randomFloat(2, 100000, 100000),
                'jumlah_pengajuan' => $faker->randomFloat(2, 1000000, 10000000),
                'jumlah_acc' => $faker->randomFloat(2, 500000, 9000000),
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('pengajuan_kredit')->insert($data);
    }
}
