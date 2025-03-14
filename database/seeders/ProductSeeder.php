<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Product::factory(20)->create();

        for ($i = 1; $i < 20; $i++) { 
            $productCode = $this->getLatestId(Product::class, 'id', 'SP0000');

            Product::create([
                'image' => '/custom/dashboard/hOw8o6Lsf06esOt6wo1Ofhqfih4KRgDuitsyzFlo.jpg',
                'product_code' => $productCode,
                'product_name' => 'Product ' . $i,
                'price' => 100000 * $i,
                'status' => 1,
                'product_category' => 'thoi_trang',
            ]);
        }
    }

    public function getLatestId($model, $numberKey, $previousKey) {
        $latestId = $model::latest($numberKey)->first();
        $key = !empty($latestId) ? ($latestId->$numberKey + 1) : 1;
        
        return $previousKey . $key;
    }
}
