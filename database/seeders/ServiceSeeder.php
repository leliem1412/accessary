<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i < 20; $i++) { 
            $productCode = $this->getLatestId(Service::class, 'id', 'DV0000');

            Service::create([
                'image' => '/custom/dashboard/F53f60aGJdU9cRk2HOz36BKKmQcvcNm3mTZ3IZdl.jpg',
                'service_code' => $productCode,
                'service_name' => 'Dịch vụ ' . $i,
                'price' => 100000 * $i,
                'status' => 1,
                'service_category' => 'my_pham',
                'duration' => '1 |##| hour',
            ]);
        }
    }

    public function getLatestId($model, $numberKey, $previousKey) {
        $latestId = $model::latest($numberKey)->first();
        $key = !empty($latestId) ? ($latestId->$numberKey + 1) : 1;
        
        return $previousKey . $key;
    }
}
