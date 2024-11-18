@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
{{ Breadcrumbs::render() }}
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="https://picsum.photos/seed/picsum/300/200" class="img-fluid rounded-start">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5>{{ __('order.ID')}} {{ $viewData["order"]->id }}</h5>
                <h5 class="card-title">
                {{ __('order.creation_date')}} {{ $viewData["order"]->created_at->format('Y-m-d H:i') }}
                </h5>
                <h5 class="card-title">
                {{ __('order.delivery_date')}} {{ $viewData["order"]->deliveryDate }}
                </h5>
                <h6>{{ __('order.products')}}</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('order.type')}}</th>
                            <th>{{ __('order.product_name')}}</th>
                            <th>{{ __('order.quantity')}}</th>
                            <th>{{ __('order.price')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($viewData["items"] as $item)
                        <tr>
                            <td>
                                @if($item->getType() == 'instrument')
                                <p>{{ __('order.instrument')}}</p>
                                @else
                                <p>{{ __('order.lesson')}}</p>
                                @endif
                            </td>
                            <td>
                                @if($item->getType() == 'instrument')
                                {{ $item->getInstrument()->getName() }}
                                @else
                                {{ $item->getLesson()->getName() }}
                                @endif
                            </td>
                            <td>
                                {{ $item->getQuantity() }}
                            </td>
                            <td>
                                $ {{ $item->getCustomPrice($item->getPrice()) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="h3 secondary">
                    Total: <p class="text-success"> $ {{ $viewData['order']->getCustomTotalPrice() }}</p>
                </div>
                <form action="{{ route('admin.order.delete', ['id' => $viewData['order']->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('order.delete_order')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
