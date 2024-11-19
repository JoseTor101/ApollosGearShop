<?php

namespace App\Http\Controllers;

use App\Interfaces\PdfGeneratorInterface;
use App\Models\Order;
use App\Util\OrderUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use InvalidArgumentException;

class OrderController extends Controller
{
    private $pdfGenerator;

    public function __construct(PdfGeneratorInterface $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function generatePdf(int $id)
    {
        $order = Order::with('itemInOrders')->findOrFail($id);
        $items = $order->getItemInOrder()->get();

        foreach ($items as $item) {
            $item->name = $item->getType() == 'instrument' ? $item->getInstrument()->getName() : $item->getLesson()->getName();
        }

        $data = [
            'order' => $order,
            'items' => $items,
        ];

        $pdfContent = $this->pdfGenerator->generate('order.pdf', $data);

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="order_'.$order->getId().'.pdf"');
    }

    public function index(Request $request): View
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $viewData = [
            'title' => 'Order - Online Store',
            'subtitle' => __('navbar.list_orders'),
            'orders' => Order::where('user_id', $user->getId())->get(),
        ];

        return view('order.index')->with('viewData', $viewData);
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cartItems = $request->session()->get('cart_items', []);

        if (! OrderUtils::validateSessionItems($cartItems)) {
            return redirect()->back()->withErrors('Invalid cart items format.');
        }

        $validator = Validator::make($request->all(), [
            'cart_items' => 'required|json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cartItems = json_decode($request->input('cart_items'), true) ?? $cartItems;

        try {
            $result = OrderUtils::processCheckoutItems($cartItems);
            $itemInOrders = $result['itemInOrders'];
            $total = $result['total'];
        } catch (InvalidArgumentException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        if ($total <= 0) {
            return redirect()->back()->withErrors('Invalid total amount.');
        }

        $order = OrderUtils::createOrder($total, $itemInOrders, auth()->id());

        $request->session()->forget('cart_items');

        return redirect()->route('order.show', ['id' => $order->id])
            ->with('message', 'Checkout successful! Your order total is $'.number_format($total / 100, 2));
    }

    public function show(int $id): View
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $order = Order::with('itemInOrders')->where('id', $id)->where('user_id', $user->getId())->firstOrFail();

        $items = $order->getItemInOrder()->get();

        $viewData = [
            'title' => 'Order Details',
            'subtitle' => 'Order ID: '.$order->getId(),
            'order' => $order,
            'items' => $items,
        ];

        return view('order.show')->with('viewData', $viewData);
    }
}
