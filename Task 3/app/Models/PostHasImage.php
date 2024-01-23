<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PostHasImage extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = [
        'caption',
        'image',
        'post_id'
    ];
}
