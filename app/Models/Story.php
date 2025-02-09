<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_title',
        'story_writer',
        'writer_img',
        'story_date',
        'story_description',
        'story_category',
        'story_category1',
        'story_cate',
        'story_rating',
        'click_count',
        'rating_count',
        'story_details',
        'banner',
        'img',
        'img_title',
        'img1',
        'img1_title',
        'img2',
        'img2_title',
        'img3',
        'img3_title',
    ];
}

