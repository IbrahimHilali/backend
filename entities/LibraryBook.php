<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string catalog_id
 * @property string title
 */
class LibraryBook extends Model
{

    use SoftDeletes, CollectPrefixes, HasActivity;

    protected $fillable = [
        'id',
        'catalog_id',
        'title',
    ];

    protected $prefixable = [
        'catalog_id',
        'title',
    ];

    /**
     * Search for a book by title
     *
     * @param Builder $query The query object
     * @param string $title The title searched for
     *
     * @return Builder
     */
    public function scopeSearchByTitle(Builder $query, $title)
    {
        return $query->whereRaw('match(title) against (? in boolean mode)', [$title]);
    }


}