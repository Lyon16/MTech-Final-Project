<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SalesTest extends TestCase
{
    use RefreshDatabase;

    private User $staff;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->staff = User::create([
            'username' => 'sales_test_staff',
            'full_name' => 'Sales Test Staff',
            'password' => 'TestPassword123!',
            'created_at' => now(),
        ]);

        $this->product = Product::create([
            'name' => 'Test Keyboard',
            'price' => 2500.00,
            'stock_quantity' => 10,
            'created_at' => now(),
        ]);

        $this->actingAs($this->staff);
    }

    public function test_staff_can_record_a_sale(): void
    {
        $response = $this->post(route('sales.store'), [
            'product_id' => $this->product->id,
            'customer_id' => null,
            'quantity' => 3,
        ]);

        $response->assertRedirect(route('sales.index'));

        $this->assertDatabaseHas('sales', [
            'product_id' => $this->product->id,
            'sold_by' => $this->staff->id,
            'customer_id' => null,
            'quantity' => 3,
            'total_price' => 7500.00,
        ]);
    }

    public function test_sale_deducts_product_stock(): void
    {
        $this->post(route('sales.store'), [
            'product_id' => $this->product->id,
            'quantity' => 3,
        ]);

        $this->assertEquals(
            7,
            $this->product->fresh()->stock_quantity
        );
    }

    public function test_sale_is_rejected_when_stock_is_insufficient(): void
    {
        $response = $this->from(route('sales.create'))
            ->post(route('sales.store'), [
                'product_id' => $this->product->id,
                'quantity' => 15,
            ]);

        $response->assertRedirect(route('sales.create'));
        $response->assertSessionHasErrors('quantity');

        $this->assertDatabaseCount('sales', 0);

        $this->assertEquals(
            10,
            $this->product->fresh()->stock_quantity
        );
    }

    public function test_walk_in_customer_is_allowed(): void
    {
        $this->post(route('sales.store'), [
            'product_id' => $this->product->id,
            'customer_id' => null,
            'quantity' => 1,
        ]);

        $this->assertDatabaseHas('sales', [
            'product_id' => $this->product->id,
            'customer_id' => null,
            'quantity' => 1,
        ]);
    }

    public function test_sales_history_displays_transactions(): void
    {
        $this->post(route('sales.store'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->get(route('sales.index'));

        $response->assertOk();
        $response->assertSee('Test Keyboard');
        $response->assertSee('Sales Test Staff');
        $response->assertSee('Walk-in Customer');
        $response->assertSee('5,000.00');
    }
}
