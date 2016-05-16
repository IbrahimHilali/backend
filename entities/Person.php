<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer                 id
 * @property string                  last_name
 * @property string                  first_name
 * @property string                  birth_date
 * @property string                  death_date
 * @property string                  bio_data
 * @property string                  bio_data_source
 * @property string                  add_bio_data
 * @property boolean                 is_organization
 * @property boolean                 auto_generated
 * @property string                  source
 *
 * @property PersonInformation[]     information
 * @property PersonPrint[]           prints
 * @property PersonInheritance[]     inheritances
 * @property BookPersonAssociation[] bookAssociations
 */
class Person extends Model
{

    use SoftDeletes, CollectPrefixes;

    public static $unknownName = 'unknown';

    protected $table = 'persons';

    protected $fillable = [
        'id',
        'last_name',
        'first_name',
        'birth_date',
        'death_date',
        'bio_data',
        'bio_data_source',
        'add_bio_data',
        'is_organization',
        'auto_generated',
        'source',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $prefixable = [
        'last_name',
    ];

    /**
     * Returns the full name of person and/or organization
     *
     * @return string
     */
    public function fullName()
    {
        $name = $this->last_name ?: static::$unknownName;

        if ($this->is_organization || $this->first_name == '') {
            return $name;
        }

        return $this->last_name . ', ' . $this->first_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function information()
    {
        return $this->hasMany(PersonInformation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prints()
    {
        return $this->hasMany(PersonPrint::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inheritances()
    {
        return $this->hasMany(PersonInheritance::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookAssociations()
    {
        return $this->hasMany(BookPersonAssociation::class);
    }

    /**
     * Search for a person by name
     *
     * @param         $query The query object
     * @param  string $name  The name searched for
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByName($query, $name)
    {
        return $query->whereRaw('match(first_name, last_name) against (? in boolean mode)', [$name]);
    }

    public function scopeFullInfo(Builder $query)
    {
        return $query->with([
            'information' => function ($query) {
                $query->whereHas('code', function ($q) {
                    $q->where('internal', false);
                });
            },
            'information.code' => function ($query) {
                $query->where('person_codes.internal', false);
            },
            'prints',
            'inheritances',
            'bookAssociations',
        ]);
    }
}
