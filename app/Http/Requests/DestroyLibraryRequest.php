<?php

namespace App\Http\Requests;

use Grimm\LibraryBook;

class DestroyLibraryRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('library.delete');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Persists delete command to database
     *
     * @param LibraryBook $book
     * @return bool
     */
    public function persist(LibraryBook $book)
    {
        $book->delete();

        return true;
    }
}
