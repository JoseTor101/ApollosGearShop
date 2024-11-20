@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="container">
    <!-- Message Display -->
    <div class="text-info text-center mb-4">
        @if (isset($viewData["message"]) && $viewData["message"])
            <h2>{{ $viewData["message"] }}</h2>
        @endif
    </div>

    <!-- Stock Cards -->
    <div class="row">
        @foreach ($viewData["stocks"] as $stock)
        <div class="col-md-4 col-lg-3 mb-3">
            <div class="card h-100 d-flex flex-column shadow-sm">
                <!-- Stock Instrument Image -->
                <div class="col-md-4">
                    {{-- 
                        <img src="{{ $stock->instrument->getImage() }}" class="card-img-top img-card" alt="Instrument Image">
                    --}}
                    <img src="{{ asset('storage/' . $stock->getInstrument()->getImage()) }}" class="card-img-top img-card" alt="Instrument Image">
                </div>

                <div class="card-body d-flex flex-column flex-grow-1">
                    <!-- Instrument Name -->
                    <h5 class="card-title">{{ $stock->getInstrument() ? $stock->getInstrument()->getName() : __('messages.unknown_instrument') }}</h5>
                    
                    <!-- Stock Details -->
                    <p class="card-text">
                        <span class="badge bg-info text-dark">{{ __('attributes.quantity') }}: {{ $stock->getQuantity() }}</span>
                        <span class="badge bg-secondary">{{ __('attributes.type') }}: {{ $stock->getType() }}</span>
                    </p>
                    
                    <!-- Comments -->
                    @if ($stock->getComments())
                        <p class="card-text">
                            <strong>{{__('attributes.comments')}}:</strong> {{ $stock->getComments() }}
                        </p>
                    @endif
                </div>

                <div class="card-footer mt-auto text-center">
                    <a href="{{ route('stock.show', ['id' => $stock->getId()]) }}" class="btn btn-primary">
                        {{ __('messages.details') }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
