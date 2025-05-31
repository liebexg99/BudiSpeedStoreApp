<?php
namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            'Elektronik',
            'Pakaian',
            'Makanan',
            'Minuman',
            'Peralatan Rumah',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create(['nama' => $kategori]);
        }
    }
}