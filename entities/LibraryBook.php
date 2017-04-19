<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string catalog_id
 * @property string title
 * @property string series_title
 * @property string denecke_teitge
 * @property string volumes
 * @property string vols_year
 * @property string numbers
 * @property string place
 * @property string publisher
 * @property string year
 * @property string pages
 * @property string handwritten_dedication
 * @property string notes_jg
 * @property string notes_wg
 * @property string notes_other
 * @property string particularities
 * @property string place_of_storage
 * @property string purchase_number
 * @property string shelf_mark
 * @property string tales_comm_1856
 * @property string handwr_add_tales_comm_1856
 * @property string external_digitization
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors()
    {
        return $this->belongsToMany(LibraryPerson::class, 'library_author_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function editors()
    {
        return $this->belongsToMany(LibraryPerson::class, 'library_editor_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function translators()
    {
        return $this->belongsToMany(LibraryPerson::class, 'library_translator_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function illustrators()
    {
        return $this->belongsToMany(LibraryPerson::class, 'library_illustrator_relation');
    }
}