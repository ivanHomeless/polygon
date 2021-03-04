<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 * @package App\Models
 * @mixin Eloquent
 */
class BlogCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];
}