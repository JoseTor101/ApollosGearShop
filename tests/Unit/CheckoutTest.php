<?php

namespace Tests\Unit;

use App\Models\Instrument;
use App\Models\ItemInOrder;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\User;
use App\Util\OrderUtils;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase; // If you run with this all your db data will be lost
    //use DatabaseTransactions;

    public function test_checkout_process_successfully()
    {
        // Step 1: Create mock data
        $user = User::factory()->create(); // Create a user
        $instrument = Instrument::factory()->withStock(5)->create(); // Create an instrument with stock
        $lesson = Lesson::factory()->create(); // Create a lesson

        $cartItems = [
            [
                'id' => $instrument->getId(),
                'type' => 'Instrument',
                'quantity' => 2,
                'product' => [
                    'id' => $instrument->getId(),
                    'name' => $instrument->getName(),
                    'price' => $instrument->getPrice(),
                ],
            ],
            [
                'id' => $lesson->getId(),
                'type' => 'Lesson',
                'quantity' => 1,
                'product' => [
                    'id' => $lesson->getId(),
                    'name' => $lesson->getName(),
                    'price' => $lesson->getPrice(),
                ],
            ],
        ];

        // Step 2: Save cart items in session
        Session::put('cart', $cartItems);

        // Step 3: Validate session items
        $this->assertTrue(OrderUtils::validateSessionItems($cartItems));

        // Step 4: Process cart items
        $checkoutData = OrderUtils::processCheckoutItems($cartItems);
        $this->assertNotEmpty($checkoutData['itemInOrders']);
        $this->assertGreaterThan(0, $checkoutData['total']);

        // Step 5: Create an order
        $order = OrderUtils::createOrder($checkoutData['total'], $checkoutData['itemInOrders'], $user->getId());

        // Step 6: Assertions on the created order
        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($checkoutData['total'], $order->getTotalPrice());
        $this->assertEquals($user->getId(), $order->getUserId());

        // Verify items in the order
        $this->assertCount(2, $order->itemInOrders);
        $this->assertEquals($instrument->getId(), $order->itemInOrders->first()->instrument_id);
        $this->assertEquals($lesson->getId(), $order->itemInOrders->last()->lesson_id);

        // Verify stock adjustment for instrument
        $instrument->refresh(); // Reload instrument from the database
        $latestStock = $instrument->getQuantity();
        // Assert that the stock has been reduced by the quantity ordered (5 - 2)
        $this->assertEquals(3, $latestStock);
    }

    public function test_restore_stock_on_order_cancellation()
    {
        // Step 1: Create mock data
        $user = User::factory()->create();
        $instrument = Instrument::factory()->withStock(5)->create(); // Initial quantity is 5
        $order = Order::factory()->create(['user_id' => $user->getId(), 'totalPrice' => 100]);

        // Create an ItemInOrder with 2 instruments
        $itemInOrder = ItemInOrder::factory()->create([
            'order_id' => $order->getId(),
            'type' => 'instrument',
            'quantity' => 2, // 2 instruments ordered
            'instrument_id' => $instrument->getId(),
        ]);

        // Step 2: Restore stock
        OrderUtils::restoreStock($order); // Ensure this method restores the stock correctly

        // Reload the instrument to reflect any changes
        $instrument->refresh();
        // Step 3: Verify stock is restored
        $this->assertEquals(5, $instrument->fresh()->getQuantity()); // Stock should return to the original quantity
    }
}
