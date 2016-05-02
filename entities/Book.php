<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string title
 * @property string short_title
 * @property integer volume
 * @property integer volume_irregular
 * @property string edition
 * @property integer year
 * @property boolean grimm
 * @property string notes
 * @property string source
 * @property BookPersonAssociation[] personAssociations
 */
class Book extends Model {

    use SoftDeletes;

    protected $table = 'books';

    protected $fillable = [
        'title', 'short_title',
        'volume', 'volume_irregular',
        'edition', 'year',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'grimm' => 'boolean',
        'volume' => 'integer',
        'volume_irregular' => 'integer',
        'year' => 'integer',
    ];

    public function addPersonOccurrence(Person $person, $page = null, $pageTo = null, $description = null, $line = null)
    {
        $bookPersonAssociation = new BookPersonAssociation();

        $bookPersonAssociation->page = $page;
        $bookPersonAssociation->page_to = $pageTo;
        $bookPersonAssociation->description = $description;
        $bookPersonAssociation->line = $line;

        $bookPersonAssociation->book()->associate($this);
        $bookPersonAssociation->person()->associate($person);

        $bookPersonAssociation->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personAssociations()
    {
        return $this->hasMany(BookPersonAssociation::class);
    }

    /**
     * Search for a book by title
     * @param  $query The query object
     * @param $title The title searched for
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByTitle($query, $title)
    {
        return $query->whereRaw('match(title, short_title) against (? in boolean mode)', [$title]);
    }
}
