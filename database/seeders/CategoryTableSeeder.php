<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = (array)[
            ['name' => 'Shoes'],
            ['name' => 'Clothing'],
            ['name' => 'Gadget'],
        ];

        Category::insert($categories);
    }
}
