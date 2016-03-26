<?php

namespace App\Http\Requests;

use Gate;
use Grimm\Book;

class BookUpdateRequest extends Request
{

    /**
     * Always returns true, the controller
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('books_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'short_title' => 'max:20',
            'year' => 'numeric|max:9999',
            'volume' => 'numeric|min:1',
            'volume_irregular' => 'numeric|min:1',
            'edition' => 'numeric|min:1',
        ];
    }

    /**
     * Persists changes to the database
     *
     * @param Book $book
     * @return bool
     */
    public function persist(Book $book)
    {
        $book->title = $this->input('title');
        $book->short_title = $this->input('short_title') ?: null;

        $book->volume = (int)$this->input('volume') ?: null;
        $book->volume_irregular = (int)$this->input('volume_irregular') ?: null;
        $book->edition = (int)$this->input('edition') ?: null;

        $book->year = (int)$this->input('year') ?: null;

        return $book->save();
    }
}
