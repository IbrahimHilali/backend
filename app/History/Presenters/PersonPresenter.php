<?php

namespace App\History\Presenters;

use App\History\HistoryEntityPresenter;
use Grimm\Person;
use Illuminate\Database\Eloquent\Model;

class PersonPresenter implements HistoryEntityPresenter
{

    public function respondsTo()
    {
        return Person::class;
    }

    public function present($model)
    {
        return [
            'id' => $model->id,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'trashed' => $model->trashed(),
            'links' => [
                'self' => route('persons.show', [$model->id])
            ]
        ];
    }
}
