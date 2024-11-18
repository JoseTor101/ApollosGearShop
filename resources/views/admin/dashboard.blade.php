@extends('layouts.app')
@section('subtitle', __('navbar.admin_subtitle'))

@section('content')
<div class="container my-4">
    <div class="row">
        <!-- Instrument Container -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('messages.instrument_list') }}</h5>
                    <div>
                        <a href="{{ route('admin.instrument.create') }}" class="btn btn-primary btn-sm">{{ __('navbar.create_instrument') }}</a>
                       
                    </div>
                </div>
                <div class="card-body">
                @foreach ($viewData["instruments"] as $instrument)
    <div class="d-flex justify-content-between align-items-center">
        <h6 class="card-title">{{ $instrument->getName() }}</h6>
        <span class="badge bg-info text-dark">{{ __('attributes.quantity') }}: {{ $instrument->getQuantity() }}</span>
        <div class="d-flex align-items-center">
            @foreach ($viewData["stocks"] as $stock)
                @if ($stock->getInstrumentId() == $instrument->getId())
                    <!-- Form to Add Stock -->
                    <form action="{{ route('admin.stock.add', $stock->getId()) }}" method="POST" class="me-2">
                        @csrf
                        <input type="hidden" name="addQuantity" value="1">
                        <button type="submit" class="btn btn-success">+</button>
                    </form>
                    <!-- Form to Lower Stock -->
                    <form action="{{ route('admin.stock.lower', $stock->getId()) }}" method="POST" class="me-2">
                        @csrf
                        <input type="hidden" name="lower_quantity" value="1">
                        <button type="submit" class="btn btn-warning">-</button>
                    </form>
                    @break
                @endif
            @endforeach
            <!-- Form to Delete Instrument -->
            <form action="{{ route('admin.instrument.delete', $instrument->getId()) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
            </form>
        </div>
    </div>
    <hr>
    @endforeach


    </div>

            </div>
        </div>

        <!-- Lessons Container -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>{{ __('messages.list_lessons') }}</h5>
                    <a href="{{ route('admin.lesson.create') }}" class="btn btn-primary btn-sm">{{ __('navbar.create_lesson') }}</a>
                </div>
                <div class="card-body">
                    @foreach ($viewData["lessons"] as $lesson)
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title">{{ $lesson->getName() }}</h6>
                        <a href="{{ route('admin.lesson.delete', ['id' => $lesson->getId()]) }}" class="btn btn-sm btn-danger">{{ __('messages.delete') }}</a>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Orders Container -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('messages.order_title') }}</h5>
                </div>
                <div class="card-body">
                    @foreach ($viewData["orders"] as $order)
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title">{{ __('attributes.order_id') }}: {{ $order->getId() }}</h6>
                        <span class="badge bg-info text-dark">{{ __('attributes.created_at') }}: {{ $order->getCreatedAt() }}</span>
                        <a href="{{ route('admin.order.show', ['id' => $order->getId()]) }}" class="btn btn-sm btn-primary">{{ __('messages.view_order') }}</a>
                        <!-- <a href="{{ route('admin.order.show', ['id' => $order->getId()]) }}" class="btn btn-sm btn-primary">{{ __('messages.view_order') }}</a> -->
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection