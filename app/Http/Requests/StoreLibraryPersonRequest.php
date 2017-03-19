<?php

namespace App\Http\Requests;

use App\Library\Services\LibraryRelationService;
use Grimm\LibraryBook;
use Grimm\LibraryPerson;

class StoreLibraryPersonRequest extends Request
{

    /**
     * @var LibraryRelationService
     */
    protected $service;

    public function __construct(LibraryRelationService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

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
            'book' => 'required|exists:library_books,id',
            'relation' => 'required|in:author,editor,translator,illustrator',
            'name' => 'required',
        ];
    }

    /**
     * Persists library person to database
     *
     * @return LibraryPerson
     */
    public function persist()
    {
        $person = new LibraryPerson();

        $person->name = $this->input('name');
        $person->note = $this->input('note');

        $person->save();

        $this->service->store(
            LibraryBook::find($this->input('book')),
            $this->input('relation'),
            $person
        );

        return $person;
    }
}
