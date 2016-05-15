<?php

namespace App\History\Presenters;

use App\History\HistoryEntityPresenter;
use Grimm\Book;

class BookPresenter implements HistoryEntityPresenter
{

    public function respondsTo()
    {
        return Book::class;
    }

    public function present($model)
    {
        return [
            'id' => $model->id,
            'title' => $model->title,
            'short_title' => $model->short_title,
            'trashed' => $model->trashed(),
            'links' => [
                'self' => route('books.show', [$model->id])
            ]
        ];
    }
}
