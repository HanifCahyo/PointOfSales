<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockMovement;
use App\Models\StockOpname;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StockMovement::create([
            'product_id' => 1,
            'movement_type' => 'IN',
            'quantity' => 50,
            'note' => 'Restock Supplier',
            'created_by' => 1 // gudang
        ]);

        StockOpname::create([
            'product_id' => 1,
            'system_stock' => 100,
            'physical_stock' => 98,
            'difference' => -2,
            'note' => '2 pcs hilang',
            'created_by' => 1 // gudang
        ]);
    }
}
