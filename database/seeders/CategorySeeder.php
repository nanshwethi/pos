<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'id' => 1,
                'title' => 'Soup',
                'slug' => 'soup',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'title' => 'Dry',
                'slug' => 'dry',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Weigh',
                'slug' => 'weigh',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'title' => 'Premium',
                'slug' => 'premium',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'title' => 'Sides',
                'slug' => 'sides',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'title' => 'Beverages',
                'slug' => 'beverages',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
