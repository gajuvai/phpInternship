<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\postHasImages;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'published_at',
        'author',
        'image'
    ];

    public function postHasImages()
    {
        return $this->hasMany(PostHasImage::class, 'post_id');
    }
}

