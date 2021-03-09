<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogPost
 * @package App\Models
 *
 * @property $slug
 * @property $is_published
 * @property $published_at
 * @property $title
 */
class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'excerpt',
        'content_raw',
        'content_html',
        'published_at',
        'is_published',
        'user_id',
    ];
    /**
     * @var mixed
     */

    /**
     * Категория статьи
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Автор статьи
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
