<?php

namespace App\History;

interface HistoryEntityPresenter
{

    public function respondsTo();

    public function present($model);
}
