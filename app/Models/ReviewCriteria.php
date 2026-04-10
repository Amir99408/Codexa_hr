<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewCriteria extends Model
{
    protected $table = 'review_criteria';

    protected $fillable = [
        'performance_review_id',
        'criteria',
        'rating',
        'comment',
    ];
}