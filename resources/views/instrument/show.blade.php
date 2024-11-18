@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
{{ Breadcrumbs::render() }}
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-4">
            {{-- 
                <img src="{{ asset('storage/' . $viewData['instrument']->getImage()) }}" class="card-img-top img-card" alt="Instrument Image">
                --}}
                <img src="{{ $viewData['instrument']->getImage() }}" class="card-img-top img-card" alt="Instrument Image">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">{{ $viewData['instrument']->getName() }}</h5>

                <!-- Details Table -->
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row">{{ __('attributes.id') }}</th>
                            <td>{{ $viewData['instrument']->getId() }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('attributes.description') }}</th>
                            <td>{{ $viewData['instrument']->getDescription() }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('attributes.category') }}</th>
                            <td>{{ $viewData['category'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('attributes.brand') }}</th>
                            <td>{{ $viewData['instrument']->getBrand() }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('attributes.price') }}</th>
                            <td>
                                <span class="text-success">{{ $viewData['instrument']->getFormattedPrice() }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('attributes.rating') }}</th>
                            <td>{{ number_format($viewData['instrument']->getReviewSum(), 1) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('attributes.number_of_reviews') }}</th>
                            <td>{{ $viewData['instrument']->getNumberOfReviews() }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('attributes.available_quantity') }}</th>
                            <td>{{ $viewData['instrument']->getQuantity() }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Show instrument reviews -->
                @include('components.review.review_list', ['viewData' => $viewData])

            </div>
            
            <div class="d-flex justify-content-center align-items-center" style="height: 18vh;">
                @csrf
                <!-- Include Add to Cart Form for Instruments -->
                @include('components.cart.add', [
                    'productId' => $viewData['instrument']->getId(),
                    'productType' => 'Instrument',
                    'maxQuantity' => $viewData['instrument']->getQuantity()
                ])
            </div>


            </div> 
        </div>
    </div>
</div>
@endsection

