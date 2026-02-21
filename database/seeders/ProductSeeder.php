<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // BARANG 1: Casing (Punya Varian Tipe HP)
        DB::table('products')->insert([
            'name' => 'Casing Transparan Anti-Crack',
            'price' => 25000,
            'description' => 'Bahan silikon lembut, tahan benturan, tidak cepat kuning.',
            'image' => 'https://placehold.co/600x400?text=Casing+HP', // Gambar dummy otomatis
            'stock' => 50,
            'variants' => 'iPhone 11,iPhone 12,iPhone 13,Samsung S23', // <--- ADA ISINYA
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // BARANG 2: Powerbank (Universal / Tidak Ada Varian)
        DB::table('products')->insert([
            'name' => 'Powerbank Robot 10000mAh',
            'price' => 150000,
            'description' => 'Fast charging 18W, dual output USB, garansi 1 tahun.',
            'image' => 'https://placehold.co/600x400?text=Powerbank',
            'stock' => 20,
            'variants' => null, // <--- KOSONG (NULL)
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // BARANG 3: Kabel Data (Punya Varian Tipe Colokan)
        DB::table('products')->insert([
            'name' => 'Kabel Data Fast Charging',
            'price' => 35000,
            'description' => 'Kabel nylon braided, support data transfer.',
            'image' => 'https://placehold.co/600x400?text=Kabel+Data',
            'stock' => 100,
            'variants' => 'Type-C,Micro USB,Lightning', // <--- ADA ISINYA
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
