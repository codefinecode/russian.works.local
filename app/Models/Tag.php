<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;
    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
