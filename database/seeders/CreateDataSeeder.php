<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Data;

class CreateDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'standar' => 'SNI 103:2017',
            'judul' => 'Kertas Tisu',
            'kategori' => 'Pokok',
            'tahun' => '2021',
            'status' => 'OK',
            'validasi_status' => 1,
            'deskripsi' => 'Ini Kertas Tisu'
        ];

        Data::create($data);
    }
}
