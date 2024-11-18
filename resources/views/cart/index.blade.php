@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="text-info text-center">
    @if (isset($viewData["message"]) && $viewData["message"])
        <h2>{{ $viewData["message"] }}</h2>
    @endif
</div>

{{ Breadcrumbs::render() }}
<div class="container">
    <h1>{{ $viewData['subtitle'] }}</h1>
    @if(count($viewData['cartProducts']) > 0)
    <ul class="list-group">
        @foreach($viewData['cartProducts'] as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                @if($item['type'] === 'Instrument')
                <strong>Instrument:</strong> {{ $item['product']->getName() }} - {{ $item['product']->getFormattedPrice() }}
                @else
                <strong>Lesson:</strong> {{ $item['product']->getName() }} - {{ $item['product']->getFormattedPrice() }}
                @endif
            </div>

            <div class="d-flex align-items-center">
                @if($item['type'] === 'Instrument')
                <form action="{{ route('cart.add', ['id' => $item['product']->id, 'type' => 'Instrument']) }}" method="POST" class="d-inline">
                    @csrf
                    <div class="input-group" style="width: 120px;">
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->getQuantity() }}" required class="form-control">
                    </div>
                </form>
                @endif

                <form action="{{ route('cart.removeItem', ['id' => $item['product']->id, 'type' => $item['type']]) }}" method="POST" class="d-inline ms-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">X</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
    <div class="d-flex justify-content-center mt-3">
        <form action="{{ route('order.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="cart_items" value="{{ json_encode($viewData['cartProducts']) }}">
            <button type="submit" class="btn btn-primary">{{ __('cart.checkout') }}</button>
        </form>

        <form action="{{ route('cart.removeAll') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mx-2">{{ __('attributes.remove_All') }}</button>
        </form>
    </div>
    @else
    <p>{{ __('cart.empty_cart') }}</p>
    @endif
</div>
@endsection
