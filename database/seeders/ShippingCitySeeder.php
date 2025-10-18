<?php

namespace Database\Seeders;

use App\Models\ShippingCity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingCity::insert([
            ['name' => 'Cairo', 'shipping_fees' => 50.00],
            ['name' => 'Alexandria', 'shipping_fees' => 70.00],
            ['name' => 'Giza', 'shipping_fees' => 55.00],
            ['name' => 'Shubra El-Kheima', 'shipping_fees' => 60.00],
            ['name' => 'Port Said', 'shipping_fees' => 90.00],
            ['name' => 'Suez', 'shipping_fees' => 85.00],
            ['name' => 'Luxor', 'shipping_fees' => 120.00],
            ['name' => 'Mansoura', 'shipping_fees' => 80.00],
            ['name' => 'El-Mahalla El-Kubra', 'shipping_fees' => 75.00],
            ['name' => 'Tanta', 'shipping_fees' => 70.00],
            ['name' => 'Asyut', 'shipping_fees' => 110.00],
            ['name' => 'Ismailia', 'shipping_fees' => 85.00],
            ['name' => 'Fayoum', 'shipping_fees' => 65.00],
            ['name' => 'Zagazig', 'shipping_fees' => 75.00],
            ['name' => 'Aswan', 'shipping_fees' => 150.00],
            ['name' => 'Damietta', 'shipping_fees' => 95.00],
            ['name' => 'Damanhur', 'shipping_fees' => 70.00],
            ['name' => 'El-Minya', 'shipping_fees' => 100.00],
            ['name' => 'Beni Suef', 'shipping_fees' => 90.00],
            ['name' => 'Qena', 'shipping_fees' => 130.00],
            ['name' => 'Sohag', 'shipping_fees' => 115.00],
            ['name' => 'Hurghada', 'shipping_fees' => 140.00],
            ['name' => '6th of October City', 'shipping_fees' => 60.00],
            ['name' => 'Shebin El-Kom', 'shipping_fees' => 70.00],
            ['name' => 'Banha', 'shipping_fees' => 65.00],
            ['name' => 'Kafr El-Sheikh', 'shipping_fees' => 80.00],
            ['name' => 'Arish', 'shipping_fees' => 160.00],
            ['name' => 'Mallawi', 'shipping_fees' => 105.00],
            ['name' => '10th of Ramadan City', 'shipping_fees' => 75.00],
            ['name' => 'Bilbais', 'shipping_fees' => 70.00],
        ]);
    }
}
