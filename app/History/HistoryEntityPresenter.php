<?php

namespace App\History;

use Illuminate\Database\Eloquent\Model;

interface HistoryEntityPresenter
{
    public function respondsTo();

    public function present($model);
}
