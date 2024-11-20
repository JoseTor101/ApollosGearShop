    @extends('layouts.app')

    @section('title', $viewData["title"])
    @section('subtitle', $viewData["subtitle"])

    @section('content')

    <div class="text-info text-center">
        @if (isset($viewData["message"]) && $viewData["message"])
        <h2>{{ $viewData["message"] }}</h2>
        @endif
    </div>

    <div class="container">
        <div class="text-info text-center mb-4">
            <h2>{{ $viewData["title"] }}</h2>
        </div>

        <!-- Stock Details -->
        <div class="card">
            <div class="card-header">
                <h3>{{ __('messages.details') }}</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <!-- Instrument Name -->
                    <dt class="col-sm-3">{{ __('attributes.name') }}:</dt>
                    <dd class="col-sm-9">{{ $viewData["stock"]->instrument->getName() }}</dd>

                    <!-- Quantity -->
                    <dt class="col-sm-3">{{ __('attributes.quantity') }}:</dt>
                    <dd class="col-sm-9">{{ $viewData["stock"]->getQuantity() }}</dd>

                    <!-- Type -->
                    <dt class="col-sm-3">{{ __('attributes.type') }}:</dt>
                    <dd class="col-sm-9">{{ $viewData["stock"]->getType() }}</dd>

                    <!-- Comments -->
                    <dt class="col-sm-3">{{ __('attributes.comments') }}:</dt>
                    <dd class="col-sm-9">{{ $viewData["stock"]->getComments() ?? __('messages.no_comments') }}</dd>

                    <!-- Created At -->
                    <dt class="col-sm-3">{{ __('attributes.created_at') }}:</dt>
                    <dd class="col-sm-9">{{ $viewData["stock"]->getCreatedAt() }}</dd>

                    <!-- Updated At -->
                    <dt class="col-sm-3">{{ __('attributes.updated_at') }}:</dt>
                    <dd class="col-sm-9">{{ $viewData["stock"]->getUpdatedAt() }}</dd>
                </dl>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.stock.index') }}" class="btn btn-primary">{{ __('messages.back_to_stock_list') }}</a>
            </div>
        </div>

        <!-- Update stock functionalities -->
        @include('components.stock.update_stock', ['viewData' => $viewData])

    </div>
    @endsection
