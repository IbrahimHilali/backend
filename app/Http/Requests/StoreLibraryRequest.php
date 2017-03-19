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
            'external_digitization' => 'url',
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

        $book->denecke_teitge = $this->input('denecke_teitge');

        $book->volumes = $this->input('volumes');
        $book->vols_year = $this->input('vols_year');
        $book->numbers = $this->input('numbers');
        $book->place = $this->input('place');
        $book->publisher = $this->input('publisher');
        $book->year = $this->input('year');
        $book->pages = $this->input('pages');
        $book->handwritten_dedication = $this->input('handwritten_dedication');

        $book->notes_jg = $this->input('notes_jg');
        $book->notes_wg = $this->input('notes_wg');
        $book->notes_other = $this->input('notes_other');

        $book->particularities = $this->input('particularities');
        $book->place_of_storage = $this->input('place_of_storage');
        $book->purchase_number = $this->input('purchase_number');
        $book->shelf_mark = $this->input('shelf_mark');

        $book->tales_comm_1856 = $this->input('tales_comm_1856');
        $book->handwr_add_tales_comm_1856 = $this->input('handwr_add_tales_comm_1856');

        $book->external_digitization = $this->input('external_digitization');

        $book->save();

        return $book;
    }
}
