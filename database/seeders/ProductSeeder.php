<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;      // Import Product model
use App\Models\Category;     // Import Category model
use App\Models\SubCategory;  // Import SubCategory model

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dogFoodCat = Category::where('name', 'Dog Supplies')->first();
        $dogFoodSubCat = SubCategory::where('name', 'Food')->first();
        $catToysCat = Category::where('name', 'Cat Supplies')->first();
        $catToysSubCat = SubCategory::where('name', 'Toy')->first();

        if ($dogFoodCat && $dogFoodSubCat) {
            Product::firstOrCreate(['sku' => 'DS-DF-1'], [
                'name' => 'Premium Adult Dog Food',
                'description' => 'Nutrient-rich food for adult dogs.',
                'price' => 45.99,
                'quantity' => 100,
                'category_id' => $dogFoodCat->id,
                'sub_category_id' => $dogFoodSubCat->id,
            ]);
            Product::firstOrCreate(['sku' => 'DS-DF-2'], [
                'name' => 'Grain-Free Puppy Kibble',
                'description' => 'Healthy start for growing puppies.',
                'price' => 32.50,
                'quantity' => 200,
                'category_id' => $dogFoodCat->id,
                'sub_category_id' => $dogFoodSubCat->id,
            ]);
        }

        if ($catToysCat && $catToysSubCat) {
            Product::firstOrCreate(['sku' => 'CS-CT-1'], [
                'name' => 'Feather Teaser Wand',
                'description' => 'Interactive toy for playful cats.',
                'price' => 9.99,
                'quantity' => 5,
                'category_id' => $catToysCat->id,
                'sub_category_id' => $catToysSubCat->id,
            ]);
            Product::firstOrCreate(['sku' => 'CS-CT-2'], [
                'name' => 'Catnip Stuffed Mouse',
                'description' => 'Classic cat toy with natural catnip.',
                'price' => 5.25,
                'quantity' => 0,
                'category_id' => $catToysCat->id,
                'sub_category_id' => $catToysSubCat->id,
            ]);
        }
    }
}
