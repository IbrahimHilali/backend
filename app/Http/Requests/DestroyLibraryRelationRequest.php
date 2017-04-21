<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Library\Services\Exceptions\InvalidRelationTypeException;
use App\Library\Services\LibraryRelationService;
use Grimm\LibraryBook;
use Grimm\LibraryPerson;

class DestroyLibraryRelationRequest extends Request
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
            'person' => 'required|exists:library_people,id',
        ];
    }

    /**
     * Persists library book and library person association to database
     *
     * @param LibraryBook $book
     * @param $relation
     * @return bool
     */
    public function persist(LibraryBook $book, $relation)
    {
        try {
            return $this->service->delete(
                $book,
                $relation,
                LibraryPerson::findOrFail($this->input('person'))
            );
        } catch (InvalidRelationTypeException $e) {
            return false;
        }
    }
}
