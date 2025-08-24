<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trx = Transaction::create([
            'invoice_no' => 'TRX001',
            'user_id' => 2, // kasir
            'total_amount' => 11000,
            'payment_method' => 'cash',
            'status' => 'completed'
        ]);

        TransactionDetail::create([
            'transaction_id' => $trx->id,
            'product_id' => 1,
            'quantity' => 2,
            'price' => 3000,
            'subtotal' => 6000
        ]);

        TransactionDetail::create([
            'transaction_id' => $trx->id,
            'product_id' => 2,
            'quantity' => 1,
            'price' => 5000,
            'subtotal' => 5000
        ]);
    }
}
