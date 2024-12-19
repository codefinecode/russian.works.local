<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Главная страница
    public function index()
    {
        $articles = Article::latest()->take(6)->get();
        return view('home', compact('articles'));
    }

    // Каталог статей
    public function catalog(Request $request)
    {
        $query = Article::query();

        // Фильтрация по тегу, если передан параметр tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.name', $request->input('tag')); // Явно указываем таблицу tags
            });
        }

        $articles = $query->latest()->paginate(10);

        // Данные из Redis
        foreach ($articles as $article) {
            $article->likes = $article->likes; // Метод getLikesAttribute
            $article->views = $article->views; // Метод getViewsAttribute
        }

        $tags = Tag::all(); // Все теги для вывода в боковой панели

        return view('articles.catalog', compact('articles', 'tags'));
    }

    // Страница статьи
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->with('tags')->firstOrFail();

        // Добавляем данные из Redis
        $article->likes = $article->likes; // Метод getLikesAttribute
        $article->views = $article->views; // Метод getViewsAttribute

        return view('articles.show', compact('article'));
    }}
