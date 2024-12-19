<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ArticleApiController extends Controller
{
    // Инкремент лайков
    public function like($id)
    {
        $key = "article:{$id}:likes";
        $likes = Redis::incr($key);

        return response()->json(['likes' => $likes]);
    }

    // Инкремент просмотров
    public function view($id)
    {
        $key = "article:{$id}:views";
        $views = Redis::incr($key);

        return response()->json(['views' => $views]);
    }

    public function comment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject' => 'required|max:255',
            'body' => 'required',
        ]);

        // Отправляем в фоновую очередь
        \App\Jobs\ProcessComment::dispatch($validated);
        return response()->json(['message' => 'Ваше сообщение успешно отправлено и должно быть обработано в течении '.config('app.comment_timeout').' секунд.']);
    }}
