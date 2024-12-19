<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    protected $fillable = ['title', 'slug', 'body', 'views'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getLikesAttribute()
    {
        $key = "article:{$this->id}:likes";
        return Redis::get($key) ?: 0;
    }

    public function getViewsAttribute()
    {
        $key = "article:{$this->id}:views";
        return Redis::get($key) ?: 0;
    }

}
