@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')

{{ Breadcrumbs::render() }}
<div class="text-info text-center">
    @if (isset($viewData["message"]) && $viewData["message"])
        <h2>{{ $viewData["message"] }}</h2>
    @endif
</div>


<!-- Filter Form -->
<div class="mb-4 d-flex justify-content-center">
    <form method="GET" action="{{ route('instrument.index') }}">
        <div class="row">
            <div class="col-md-3">
                <select id="category" name="category" class="form-control text-dark" style="background-color: #d1d5db">
                    <option value="">{{ __('attributes.placeholders.category') }}</option>
                    @foreach ($viewData['categories'] as $key => $category)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="rating" name="rating" class="form-control" style="background-color: #d1d5db">
                    <option value="">{{ __('attributes.placeholders.rating') }}</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="filterOrder" id="filterOrder" class="form-control" style="background-color: #d1d5db"  >
                 
                    <option value="">{{ __('attributes.placeholders.order') }}</option>
                    <option value="priceAsc" {{ request('filterOrder') == 'priceAsc' ? 'selected' : '' }}>
                        {{ __('attributes.order.priceAsc') }}
                    </option>
                    <option value="priceDesc" {{ request('filterOrder') == 'priceDesc' ? 'selected' : '' }}>
                        {{ __('attributes.order.priceDesc') }}
                    </option>
                    <option value="ratingAsc" {{ request('filterOrder') == 'ratingAsc' ? 'selected' : '' }}>
                        {{ __('attributes.order.ratingAsc') }}
                    </option>
                    <option value="ratingDesc" {{ request('filterOrder') == 'ratingDesc' ? 'selected' : '' }}>
                        {{ __('attributes.order.ratingDesc') }}
                    </option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="filterComment" id="filterComment" class="form-control" style="background-color: #d1d5db"  >
                    <option value="">{{ __('attributes.placeholders.comments') }}</option>
                    <option value="mostCommented" {{ request('filterComment') ? 'selected' : '' }}>
                        {{ __('attributes.mostCommented') }}
                    </option>
                </select>
            </div>


            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">{{ __('attributes.filter') }}</button>
            </div>
        </div>
    </form>
</div>



<div class="row">
    @foreach ($viewData["instruments"] as $instrument)
    <div class="col-md-4 col-lg-3 mb-3">
        <div class="card h-100 shadow-sm">
            <!-- Instrument Image -->
            {{-- 
                <img src="{{ asset('storage/' . $instrument->getImage()) }}" class="card-img-top img-card" alt="Instrument Image">
                --}}
                <img src="{{ $instrument->getImage() }}" class="card-img-top img-card" alt="Instrument Image">
            

            <div class="card-body text-center">
                <!-- Instrument Name -->
                <h5 class="card-title">{{ $instrument->getName() }}</h5>
                
                <!-- Brand and Category -->
                <p class="card-text">
                    <span class="badge bg-info text-dark">{{ $instrument->getBrand() }}</span>
                    <span class="badge bg-secondary">{{ $viewData['categories'][$instrument->getCategory()] ?? 'Unknown Category' }}</span>
                </p>
                
                <!-- Price -->
                <p class="card-text text-success">
                    <strong>Price:</strong> ${{ number_format($instrument->getPrice(), 2) }}
                </p>

                <!-- Review Information -->
                <p class="card-text">
                    <strong>Rating:</strong> {{ number_format($instrument->getReviewSum(), 1) }} 
                    <span class="text-muted">({{ $instrument->getNumberOfReviews() }} reviews)</span>
                </p>

                <!-- Short Description -->
                <p class="card-text">
                    {{ Str::limit($instrument->getDescription(), 60) }} <!-- Limit description length -->
                </p>

                <!-- Details Button -->
                <a href="{{ route('instrument.show', ['id'=>  $instrument->getId()]) }}" class="btn btn-primary">
                    {{ __('messages.details') }}
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- Pagination Links -->
<div class="d-flex justify-content-center">
    {{ $viewData['instruments']->links() }}
</div>


{{--
<div class="row">
    @foreach ($viewData["instruments"] as $instrument)
    <div class="col-md-4 col-lg-3 mb-2">
        <div class="card">
            <img src="https://picsum.photos/seed/picsum/300/200" class="card-img-top img-card">
            <div class="card-body text-center">
                <h5>ID: {{ $instrument->getId() }}</h5>
                <a href="{{ route('instrument.show', ['id'=>  $instrument->getId()]) }}"
                    class="btn bg-primary text-white">{{ $instrument->getName() }}</a>
            </div>
        </div>
    </div>  
    @endforeach
</div>
@endsection
--}}
@endsection