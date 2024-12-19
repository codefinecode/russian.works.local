<?php

namespace App\Console\Commands;

use App\Models\ArticleCounter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class SyncCounters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:article-counters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация лайков и просмотров из Redis в базу данных';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('counters:sync call start++');
        $keys = Redis::keys('article:*');
        foreach ($keys as $key) {
            // Парсинг ключа
            preg_match('/article:(\d+):(likes|views)/', $key, $matches);
            $articleId = $matches[1];
            $field = $matches[2];

            // Получение значения из Redis
            $value = Redis::get($key);

            // Сохранение в базу данных
            $counter = ArticleCounter::firstOrCreate(['article_id' => $articleId]);
            $counter->increment($field, $value);

            // Удаление значения из Redis после синхронизации
            Redis::del($key);
        }

        $this->info('Счётчики успешно синхронизированы.');
        Log::info('counters:sync call end----');


    }
}
