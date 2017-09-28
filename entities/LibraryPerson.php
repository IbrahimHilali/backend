<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string name
 * @property string note
 * @property LibraryBook[] written
 * @property LibraryBook[] edited
 * @property LibraryBook[] translated
 * @property LibraryBook[] illustrated
 */
class LibraryPerson extends Model
{

    use SoftDeletes, CollectPrefixes, HasActivity;

    protected $fillable = [
        'id',
        'name',
        'note',
    ];

    protected $prefixable = [
        'name',
    ];

    public function totalBookCount()
    {
        return $this->edited()->count()
            + $this->written()->count()
            + $this->translated()->count()
            + $this->illustrated()->count();
    }

    /**
     * Search for a book by title
     *
     * @param Builder $query The query object
     * @param string $title The title searched for
     *
     * @return Builder
     */
    public function scopeSearchByName(Builder $query, $title)
    {
        return $query->whereRaw('match(name) against (? in boolean mode)', [$title]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function written()
    {
        return $this->belongsToMany(LibraryBook::class, 'library_author_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function edited()
    {
        return $this->belongsToMany(LibraryBook::class, 'library_editor_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function translated()
    {
        return $this->belongsToMany(LibraryBook::class, 'library_translator_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function illustrated()
    {
        return $this->belongsToMany(LibraryBook::class, 'library_illustrator_relation');
    }
}