@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">Каталог статей</h1>
        <div class="row">
            <div class="col-12 col-lg-4 mb-3">
                <h3>Теги:</h3>
                @foreach ($tags as $tag)
                    <a href="{{ url('/articles?tag=' . $tag->name) }}" class="badge bg-secondary link-underline-light"
                    >{{ $tag->name }}</a>
                @endforeach
            </div>
            <div class="col-12  col-lg-8">
                @foreach ($articles as $article)
                    <div class="card mb-4">
                        <img src="https://via.placeholder.com/250x100" class="card-img-top" alt="{{ $article->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->body, 200) }}</p>
                            <div class="d-flex justify-content-between">
                            <div class="mb-2">
                                @foreach ($article->tags as $tag)
                                    <a href="{{ url('/articles?tag=' . $tag->name) }}" class="badge bg-info">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                            <p>
                                <span class="text-success">❤ <span class="badge bg-secondary">{{ $article->likes }}</span></span> |
                                <span class="text-primary">👀 <span class="badge bg-secondary">{{ $article->views }}</span></span>
                            </p>
                            </div>
                            <a href="{{ url('/articles/' . $article->slug) }}" class="btn btn-primary">Читать</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{--  Пагинация --}}
        {{ $articles->links() }}
    </div>
@endsection
