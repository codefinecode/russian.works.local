@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Последние статьи</h1>
        <div class="row">
            @foreach ($articles as $article)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm" onclick="window.location='{{ url('/articles/' . $article->slug) }}'" style="cursor: pointer;">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $article->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->body, 100) }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <span>❤ {{ $article->likes ?? 0 }}</span>
                            <span>👀 {{ $article->views ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
