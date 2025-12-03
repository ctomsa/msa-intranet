<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

   protected $fillable = [
    'title',
    'label',
    'audience',
    'department',
    'excerpt',
    'content',
    'published_at',
    'author_id', 
];

protected $casts = [
        'published_at' => 'datetime',   // 👈 вот это добавляем
    ];
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}