<form action="{{ route('cart.add', ['id' => $productId, 'type' => $productType]) }}" method="POST" class="d-flex  justify-content-center align-items-center">
    @csrf
    <div class="form-group mr-2" style="margin-top: -5vh;">
        <label for="quantity" class="mr-2"><h6>{{ __('cart.quantity') }}</h6></label>
        <input type="number" name="quantity" id="quantity" class="form-control bg-success" value="1" min="1" max="{{ $maxQuantity }}" style="width: 90px;">
    </div>
    <button type="submit" class="btn btn-primary">{{ __('cart.add_to_cart') }}</button>
</form>
