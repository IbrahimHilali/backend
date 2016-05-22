<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer                 id
 * @property string                  title
 * @property string                  short_title
 * @property integer                 volume
 * @property integer                 volume_irregular
 * @property string                  edition
 * @property integer                 year
 * @property boolean                 grimm
 * @property string                  notes
 * @property string                  source
 * @property BookPersonAssociation[] personAssociations
 */
class Book extends Model
{

    use SoftDeletes, CollectPrefixes;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'short_title',
        'volume',
        'volume_irregular',
        'edition',
        'year',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'grimm' => 'boolean',
        'volume' => 'integer',
        'volume_irregular' => 'integer',
        'year' => 'integer',
    ];

    protected $prefixable = [
        'short_title',
        'title',
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
     *
     * @param Builder     $query The query object
     * @param             $title The title searched for
     *
     * @return Builder
     */
    public function scopeSearchByTitle(Builder $query, $title)
    {
        return $query->whereRaw('match(title, short_title) against (? in boolean mode)', [$title]);
    }

    protected static function boot()
    {
        parent::boot();

        static::restored(function (Book $model) {
            $model->personAssociations()->whereHas('person', function($q) {
                $q->whereNull('deleted_at');
            })->restore();
        });

        static::deleted(function (Book $model) {
            $model->personAssociations()->delete();
        });
    }
}
