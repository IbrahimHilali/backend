<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Book book
 * @property Person person
 * @property integer book_id
 * @property integer person_id
 * @property integer page
 * @property integer page_to
 * @property string page_description
 * @property integer line
 */
class BookPersonAssociation extends Model {

    use SoftDeletes;

    protected $table = 'book_person';

    protected $fillable = ['page', 'page_to', 'page_description', 'line'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
