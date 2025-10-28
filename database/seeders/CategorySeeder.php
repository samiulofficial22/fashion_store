<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'T-Shirt', 'slug' => 't-shirt', 'status' => 1],
            ['name' => 'Shirt', 'slug' => 'shirt', 'status' => 1],
            ['name' => 'Panjabi', 'slug' => 'panjabi', 'status' => 1],
            ['name' => 'Jeans Pant', 'slug' => 'jeans-pant', 'status' => 1],
            ['name' => 'Shorts', 'slug' => 'shorts', 'status' => 1],
            ['name' => 'Accessories', 'slug' => 'accessories', 'status' => 1],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']], // unique by slug
                $cat
            );
        }
    }
}
