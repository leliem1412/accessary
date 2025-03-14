<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Liem Le',
        //     'email' => 'jos.tuanliem@gmail.com',
        //     'password' => bcrypt('123'),
        // ]);

        $this->call([
            ProductSeeder::class,
            // Customer::class,
            ServiceSeeder::class,
        ]);
    }
}
