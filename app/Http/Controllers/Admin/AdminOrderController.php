<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Util\OrderUtils;
use Illuminate\Http\RedirectResponse;

class AdminOrderController extends Controller
{
    public function delete(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        OrderUtils::restoreStock($order);

        $order->delete();

        return redirect()->route('admin.index')->with('message', 'Order deleted successfully.');
    }
}
