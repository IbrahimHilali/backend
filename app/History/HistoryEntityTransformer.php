<?php

namespace App\History;

use Grimm\Activity;

class HistoryEntityTransformer
{

    /**
     * @var HistoryEntityPresenter[]
     */
    protected $presenters = [];

    public function addPresenter(HistoryEntityPresenter $entityPresenter)
    {
        $this->presenters[$entityPresenter->respondsTo()] = $entityPresenter;

        return $this;
    }

    public function addPresenters(array $entityPresenters)
    {
        foreach($entityPresenters as $presenter) {
            $this->addPresenter($presenter);
        }

        return $this;
    }

    public function presentEntity(Activity $activity)
    {
        //dd($activity->model);
        // var_dump($activity->id, $activity->model_id, $activity->log['action']);
        return $this->presenters[$activity->model_type]->present($activity->model);
    }

    public function getType(Activity $activity)
    {
        return $activity->model_type;
    }
}
