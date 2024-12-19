@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $article->title }}</h1>
        <img src="https://via.placeholder.com/800x400" alt="{{ $article->title }}" class="img-fluid mb-4">
        <p>{{ $article->body }}</p>

        <div>
            <strong>Теги:</strong>
            @foreach ($article->tags as $tag)
                <a href="{{ url('/articles?tag=' . $tag->name) }}" class="badge bg-info">{{ $tag->name }}</a>
            @endforeach
        </div>
        <hr>
        <div class="mt-4 d-flex justify-content-between">
            <button id="like-btn" class="btn btn-secondary">
                ❤ <span id="like-count">{{ $article->likes ?? 0 }}</span>
            </button>
            <span>👀 <span id="view-count">{{ $article->views ?? 0 }}</span></span>
        </div>

        <form id="comment-form" class="mt-4">
            <h2>Оставить комментарий</h2>
            <div class="mb-3">
                <label for="subject" class="form-label">Тема</label>
                <input type="text" class="form-control" id="subject" required>
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Сообщение</label>
                <textarea class="form-control" id="body" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Отправить</button>
        </form>
        <div id="success-message" class="alert alert-success mt-4" style="display: none;">
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('like-btn').addEventListener('click', function () {
            fetch(`/api/articles/{{ $article->id }}/like`, {method: 'POST'})
                .then(response => response.json())
                .then(data => document.getElementById('like-count').textContent = data.likes);
        });

        document.getElementById('comment-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const subject = document.getElementById('subject').value;
            const body = document.getElementById('body').value;
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            successMessage.style.display = 'none';
            successMessage.textContent = '';
            if (errorMessage) {
                errorMessage.remove();
            }

            fetch('/api/comments', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({subject, body}),
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Произошла ошибка при отправке комментария');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    successMessage.textContent = data.message;
                    successMessage.style.display = 'block';
                })
                .catch(error => {
                    const errorElement = document.createElement('div');
                    errorElement.id = 'error-message';
                    errorElement.className = 'alert alert-danger mt-4';
                    errorElement.textContent = error.message;
                    document.getElementById('comment-form').insertAdjacentElement('beforebegin', errorElement);
                });
        });

        window.addEventListener('load', function () {
            setTimeout(function () {
                fetch(`/api/articles/{{ $article->id }}/view`, {method: 'POST'})
                    .then(response => response.json())
                    .then(data => document.getElementById('view-count').textContent = data.views);
            }, 5000);
        });
    </script>
@endsection
