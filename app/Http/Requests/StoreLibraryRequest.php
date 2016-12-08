<?php

namespace App\Http\Requests;

use Grimm\LibraryBook;

class StoreLibraryRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('library.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'catalog_id' => 'required|unique:library_books',
            'title' => 'string|required',
        ];
    }

    /**
     * Persists book into database and returns it
     *
     * @return LibraryBook
     */
    public function persist()
    {
        $book = new LibraryBook();

        $book->catalog_id = $this->input('catalog_id');
        $book->title = $this->input('title');

        $book->save();

        return $book;
    }
}
