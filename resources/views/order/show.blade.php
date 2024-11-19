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
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-black">{{ __('order.ID')}}</th>
                        <td>{{ $viewData["order"]->getId() }}</td>
                    </tr>
                    <tr>
                        <th class="text-black">{{ __('order.creation_date')}}</th>
                        <td>{{ $viewData["order"]->getCreatedAt() }}</td>
                    </tr>
                    <tr>
                        <th class="text-black">{{ __('order.delivery_date')}}</th>
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

                        <tr>
                            <th colspan="3">
                                <h4>
                                    Total:
                                </h4>
                            </th>
                            <td>
                                <h4 class="text-success ml-2!important">  $ {{ $viewData['order']->getCustomTotalPrice() }}</h4> 
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <div class="h3 secondary d-flex flex-direction-row">
                        Total: <p class="text-success ml-2!important">  $ {{ $viewData['order']->getCustomTotalPrice() }}</p>
                    </div>

                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <a href="{{ route('order.pdf', ['id' => $viewData['order']->getId()]) }}" class="btn btn-info">
                        {{ __('order.generate_pdf')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
