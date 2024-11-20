<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    thead tr {
        background-color: #f2f2f2;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
    }
</style>
<h1>{{ __('order.order_id')}}: {{ $order->getId() }}</h1>
<h2>{{ __('order.customer')}}: {{ $order->getUser()->getName() }}</h2>
<h2>{{ __('order.creation_date')}}: {{ $order->getCreatedAt() }}</h2>
<h2>{{ __('order.delivery_date')}}: {{ $order->getDeliveryDate() }}</h2>
<table>
    <thead>
        <tr>
            <th>{{ __('order.product') }}</th>
            <th>{{ __('order.quantity') }}</th>
            <th>{{ __('order.price') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->itemInOrders as $item)
            <tr>
                <td>{{ $item->getType() }}</td>
                <td>{{ $item->getQuantity() }}</td>
                <td>{{ $item->getPrice() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<h2>Total: ${{ $order->getCustomTotalPrice() }}</h2>