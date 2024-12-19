<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 120) as $index) {
            Article::factory(10)->create()->each(function ($article) {
                // Прикрепляем случайное количество тегов (1-5) к статье
                $tags = Tag::inRandomOrder()->take(rand(1, 5))->pluck('id');
                $article->tags()->attach($tags);
            });
        }
    }
}
