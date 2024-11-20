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
                <h2>Info:</h2>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-black bg-light">{{ __('order.ID')}}</th>
                        <td>{{ $viewData["order"]->getId() }}</td>
                    </tr>
                    <tr>
                        <th class="text-black bg-light">{{ __('order.creation_date')}}</th>
                        <td>{{ $viewData["order"]->getCreatedAt() }}</td>
                    </tr>
                    <tr>
                        <th class="text-black bg-light">{{ __('order.delivery_date')}}</th>
                        <td>{{ $viewData["order"]->getDeliveryDate() }}</td>
                    </tr>
                </table>
                <h2>{{ __('order.products')}}</h2>
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
                <div class="d-flex justify-content-center">
                    <div class="h3 secondary d-flex flex-direction-row">
                        Total: <p class="text-success ml-2!important">  $ {{ $viewData['order']->getCustomTotalPrice() }}</p>
                    </div>

                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <!-- Generate PDF -->
                    <a href="{{ route('order.document', ['id' => $viewData['order']->getId(), 'type' => 'pdf']) }}" class="btn btn-info me-2">
                        {{ __('order.generate_pdf') }}
                    </a>

                    <!-- Generate CSV -->
                    <a href="{{ route('order.document', ['id' => $viewData['order']->getId(), 'type' => 'csv']) }}" class="btn btn-success">
                        {{ __('order.generate_csv') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
