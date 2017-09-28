<?php

namespace App\Http\Requests;

use App\Library\Services\LibraryRelationService;
use Grimm\LibraryPerson;
use Illuminate\Foundation\Http\FormRequest;

class CombinePeopleRequest extends FormRequest
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
            'person' => 'different:' . $this->route()->parameter('libraryperson')
        ];
    }

    /**
     * @param LibraryPerson $person
     * @param LibraryPerson $other
     * @return bool
     */
    public function persist(LibraryPerson $person, LibraryPerson $other)
    {
        $lookup = [
            'written' => 'author',
            'edited' => 'editor',
            'illustrated' => 'illustrator',
            'translated' => 'translator',
        ];

        foreach ($lookup as $collection => $relation) {
            foreach ($person->{$collection} as $book) {
                $this->service->store($book, $relation, $other);
            }
        }

        $person->forceDelete();

        return true;
    }
}
