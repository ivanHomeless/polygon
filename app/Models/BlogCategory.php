<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 * @package App\Models
 * @mixin Eloquent
 * @property $id
 * @property $title
 * @property $slug
 *
 */

class BlogCategory extends Model
{
    use SoftDeletes;

    const ROOT = 1;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @var mixed|string
     */
    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    public function getParentTitleAttribute()
    {
        return $this->parentCategory->title
        ?? ($this->isRoot()
            ? 'Корень'
            : '???');
    }

    /**
     * Accessor
     * @param $valueFromObject
     * @return bool|false|string|string[]|null
     */
    public function getTitleAttribute($valueFromObject)
    {
        return mb_strtoupper($valueFromObject);
    }

    protected function isRoot()
    {
        return $this->id == self::ROOT;
    }

    /**
     * Mutator
     * @param $incomingValue
     * @return bool|false|string|string[]|null
     */
    public function setTitleAttribute($incomingValue)
    {
        return $this->attributes['title'] = mb_strtolower($incomingValue);
    }

}
