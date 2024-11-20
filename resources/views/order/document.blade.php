<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
    <h1>Order ID: {{ $order->getId() }}</h1>
    <h2>Customer: {{ $order->getUser()->getName() }}</h2>
    <h3>Total Price: {{ $order->getCustomTotalPrice() }}</h3>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
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
</body>
</html>
