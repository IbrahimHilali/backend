<?php

namespace App\Http\Requests;

use Grimm\LibraryBook;

class UpdateLibraryRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('library.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'catalog_id' => 'required|unique:library_books,catalog_id,' . $this->route()->parameter('library'),
            'title' => 'string|required',
        ];
    }

    /**
     * @param LibraryBook $book
     *
     * @return bool
     */
    public function persist(LibraryBook $book)
    {
        $book->catalog_id = $this->input('catalog_id');
        $book->title = $this->input('title');

        return $book->save();
    }
}
