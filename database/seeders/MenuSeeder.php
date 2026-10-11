<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultMenus = [

            // Soup (Unit: Bowl)
            [
                'title' => 'Classic Tomato Soup',
                'slug' => 'classic-tomato-soup',
                'price' => 2500,
                'unit' => 'Bowl',
                'image' => '1.png',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mala Tomato Soup',
                'slug' => 'mala-tomato-soup',
                'price' => 2800,
                'unit' => 'Bowl',
                'image' => '2.png',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mala Golden Soup',
                'slug' => 'mala-golden-soup',
                'price' => 3000,
                'unit' => 'Bowl',
                'image' => '3.png',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mushroom Soup',
                'slug' => 'mushroom-soup',
                'price' => 2800,
                'unit' => 'Bowl',
                'image' => '4.png',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tom Yum Soup',
                'slug' => 'tom-yum-soup',
                'price' => 2500,
                'unit' => 'Bowl',
                'image' => '5.png',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Chicken Bone Broth',
                'slug' => 'chicken-bone-broth',
                'price' => 2500,
                'unit' => 'Bowl',
                'image' => '6.png',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dry (Unit: Bowl)
            [
                'title' => 'Mala Xiang Guo',
                'slug' => 'mala-xiang-guo',
                'price' => 2500,
                'unit' => 'Bowl',
                'image' => '7.png',
                'category_id' => 2,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mala Stir-fry',
                'slug' => 'mala-stir-fry',
                'price' => 2500,
                'unit' => 'Bowl',
                'image' => '8.png',
                'category_id' => 2,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Weigh (Unit: 1g)
            [
                'title' => 'Self-Select Ingredients',
                'slug' => 'self-select-ingredients',
                'price' => 35,
                'unit' => '1g',
                'image' => '9.png',
                'category_id' => 3,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Premium (Unit: 1g)
            [
                'title' => 'Premium Meat & Seafood',
                'slug' => 'premium-meat-seafood',
                'price' => 55,
                'unit' => '1g',
                'image' => '10.png',
                'category_id' => 4,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sides
            [
                'title' => 'Steamed Rice',
                'slug' => 'steamed-rice',
                'price' => 1000,
                'unit' => 'Bowl',
                'image' => '11.png',
                'category_id' => 5,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Fried Egg',
                'slug' => 'fried-egg',
                'price' => 1000,
                'unit' => 'Pcs',
                'image' => '12.png',
                'category_id' => 5,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mala Sauce',
                'slug' => 'mala-sauce',
                'price' => 500,
                'unit' => 'Bowl',
                'image' => '13.png',
                'category_id' => 5,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Signature Sauce',
                'slug' => 'signature-sauce',
                'price' => 500,
                'unit' => 'Bowl',
                'image' => '14.png',
                'category_id' => 5,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Beverages
            [
                'title' => 'Drinking Water',
                'slug' => 'drinking-water',
                'price' => 800,
                'unit' => 'Bottle',
                'image' => '15.png',
                'category_id' => 6,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sprite',
                'slug' => 'sprite',
                'price' => 2000,
                'unit' => 'Can',
                'image' => '16.png',
                'category_id' => 6,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pepsi',
                'slug' => 'pepsi',
                'price' => 2000,
                'unit' => 'Can',
                'image' => '17.png',
                'category_id' => 6,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cola',
                'slug' => 'cola',
                'price' => 2000,
                'unit' => 'Can',
                'image' => '18.png',
                'category_id' => 6,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Chinese Herbal Tea',
                'slug' => 'chinese-herbal-tea',
                'price' => 2500,
                'unit' => 'Cup',
                'image' => '19.png',
                'category_id' => 6,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($defaultMenus as $menu) {
            $sourcePath = public_path('images/' . $menu['image']);
            $destinationPath = $menu['image'];
            Storage::put($destinationPath, File::get($sourcePath), 'public');
        }
        Menu::insert($defaultMenus);
    }
}
