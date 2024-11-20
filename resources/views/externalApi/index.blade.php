@extends('layouts.app')

@section('title', __('messages.title'))

@section('content')
<div class="container mt-4">
    <div class="row" id="infoProducts">
        @if(isset($viewData['games']) && !empty($viewData['games']))
            @foreach($viewData['games'] as $game)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $game['image'] }}" class="card-img-top" alt="{{ $game['name'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $game['name'] }}</h5>
                            <p class="card-text">Price: ${{ $game['price'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif(isset($viewData['error']))
            <p class="text-danger">{{ $viewData['error'] }}</p>
        @else
            <p class="text-warning">No games found or the API did not return any data.</p>
        @endif
    </div>
</div>
@endsection
