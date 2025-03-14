<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 5; $i++) { 
            Customer::create([
                'name' => 'Liem Le ' . $i,
                'email' => 'liem.le' . $i . '@gmail.com',
                'phone' => '098765432' . $i,
            ]);
        }
    }
}
