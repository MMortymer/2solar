<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\System;
use App\Models\Product;
use App\Models\Order;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database with initial data
        $this->seed();
    }

    public function test_place_order_successfully()
    {
        $response = $this->postJson('/api/place-order', [
            'items' => [
                [
                    'system_id' => 1,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Order placed successfully']);

        $this->assertDatabaseHas('orders', [
            'system_id' => 1,
            'quantity' => 2,
        ]);

        $solarPanel = Product::find(1);
        $inverter = Product::find(2);
        $optimizer = Product::find(3);

        // Verify the stock levels after placing the order
        $this->assertEquals(976, $solarPanel->stock);
        $this->assertEquals(98, $inverter->stock);
        $this->assertEquals(476, $optimizer->stock);
    }

    public function test_place_order_insufficient_stock()
    {
        $response = $this->postJson('/api/place-order', [
            'items' => [
                [
                    'system_id' => 1,
                    'quantity' => 100,
                ],
            ],
        ]);

        $response->assertStatus(500);
        $response->assertJson(['message' => 'Failed to place order: Insufficient stock for product: Solar Panel']);

        $this->assertDatabaseMissing('orders', [
            'system_id' => 1,
            'quantity' => 100,
        ]);
    }

    public function test_place_order_does_not_exceed_stock_limits()
    {
        $response = $this->postJson('/api/place-order', [
            'items' => [
                [
                    'system_id' => 1,
                    'quantity' => 40, // Adjust as needed based on stock levels
                ],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Order placed successfully']);

        $this->assertDatabaseHas('orders', [
            'system_id' => 1,
            'quantity' => 40,
        ]);

        $solarPanel = Product::find(1);
        $inverter = Product::find(2);
        $optimizer = Product::find(3);

        // Verify the stock levels after placing the order
        $this->assertEquals(520, $solarPanel->stock); // Update these values as necessary
        $this->assertEquals(60, $inverter->stock);
        $this->assertEquals(20, $optimizer->stock);
    }
}
