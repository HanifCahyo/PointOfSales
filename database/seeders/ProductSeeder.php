<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'category_id' => 1,
            'code' => 'PRD001',
            'name' => 'Indomie Goreng',
            'price' => 3000,
            'stock' => 100
        ]);

        Product::create([
            'category_id' => 2,
            'code' => 'PRD002',
            'name' => 'Kopi Kapal Api',
            'price' => 2000,
            'stock' => 50
        ]);

        Product::create([
            'category_id' => 3,
            'code' => 'PRD003',
            'name' => 'Buku Tulis',
            'price' => 5000,
            'stock' => 30
        ]);
    }
}
