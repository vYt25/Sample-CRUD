<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [ ['name' => 'Nike Shoes','description' => 'high cut shoes','price' => '1200', 'quantity' => '10','category' => '1',],
            [
                'name' => 'Shein Clothes',
                'description' => 'T-shirt',
                'price' => '500',
                'quantity' => '20',
                'category' => '2',
            ],
            [
                'name' => 'Iphone 13 pro max',
                'description' => 'mobile phone',
                'price' => '100000',
                'quantity' => '5',
                'category' => '3',
            ],
            [
                'name' => 'Samsung S22 Ultra',
                'description' => 'mobile phone',
                'price' => '80000',
                'quantity' => '22',
                'category' => '3',
            ],
            [
                'name' => 'Samsung Galaxy Z Fold3',
                'description' => 'mobile phone',
                'price' => '70000',
                'quantity' => '15',
                'category' => '3',
            ]
        ];

        Product::insert($products);
    }
}
