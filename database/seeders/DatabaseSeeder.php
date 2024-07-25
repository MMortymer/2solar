<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\System;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create Products
        $solarPanel = Product::create([
            'name' => 'Solar Panel',
            'stock' => 1000,
            'initial_stock' => 1000,
            'low_stock_email_sent' => false,
        ]);

        $inverter = Product::create([
            'name' => 'Inverter',
            'stock' => 100,
            'initial_stock' => 100,
            'low_stock_email_sent' => false,
        ]);

        $optimizer = Product::create([
            'name' => 'Optimizer',
            'stock' => 500,
            'initial_stock' => 500,
            'low_stock_email_sent' => false,
        ]);

        // Create First System
        $basicSystem = System::create(['name' => 'Basic System']);
        // Attach products to the first system
        $basicSystem->products()->attach($solarPanel->id, ['quantity' => 12]);
        $basicSystem->products()->attach($inverter->id, ['quantity' => 1]);
        $basicSystem->products()->attach($optimizer->id, ['quantity' => 12]);

        // Create Second System
        $advancedSystem = System::create(['name' => 'Advanced System']);
        // Attach products to the second system
        $advancedSystem->products()->attach($solarPanel->id, ['quantity' => 24]);
        $advancedSystem->products()->attach($inverter->id, ['quantity' => 2]);
        $advancedSystem->products()->attach($optimizer->id, ['quantity' => 24]);
    }
}
