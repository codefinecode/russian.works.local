<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCounter extends Model
{
    protected $fillable = ['article_id', 'likes', 'views'];
}
