<?php

namespace Database\Seeders;


use App\Enums\OrderType;
use App\Enums\PosPaymentMethod;
use App\Models\Order;
use Illuminate\Database\Seeder;

class PosPaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::where('order_type', OrderType::POS)
        ->update([
            'pos_payment_method' => PosPaymentMethod::CASH
        ]);
    }
}
