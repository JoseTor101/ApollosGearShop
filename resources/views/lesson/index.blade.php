@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
{{ Breadcrumbs::render() }}

<div class="row">
    @foreach ($viewData["lessons"] as $lesson)
    <div class="col-md-4 col-lg-3 mb-3">
        <div class="card h100 shadow-sm">
            <img src="https://picsum.photos/seed/picsum/300/200" class="card-img-top img-card">
            
            <div class="card-body text-center">
                <h4>{{ $lesson->getName()}}</h4>
                <h6>Difficulty: {{ $lesson->getDifficulty()}}</h6>

                <p class="card-text text-success">
                    <strong>Price:</strong> {{ $lesson->getFormattedPrice() }}
                </p>

                <a href="{{ route('lesson.show', ['id'=> $lesson->getId()]) }}"
                    class="btn bg-primary text-white">{{__('messages.details')}}</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center">
    {{ $viewData['lessons']->links() }}
</div>

@endsection