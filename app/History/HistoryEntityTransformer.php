<?php

namespace App\History;

use Grimm\Activity;

class HistoryEntityTransformer
{

    /**
     * Create a new HistoryEntityTransformer and optionally register some entity presenters.
     *
     * @param array $entityPresenters
     */
    public function __construct(array $entityPresenters=[])
    {
        $this->addPresenters($entityPresenters);
    }

    /**
     * @var HistoryEntityPresenter[]
     */
    protected $presenters = [];

    /**
     * Register a presenter for an entity, that appears in the history.
     *
     * @param HistoryEntityPresenter $entityPresenter
     *
     * @return $this
     */
    public function addPresenter(HistoryEntityPresenter $entityPresenter)
    {
        $this->presenters[$entityPresenter->respondsTo()] = $entityPresenter;

        return $this;
    }

    /**
     * Register multiple presenters for an entity, that appears in the history.
     *
     * @param array $entityPresenters
     *
     * @return $this
     */
    public function addPresenters(array $entityPresenters)
    {
        foreach ($entityPresenters as $presenter) {
            $this->addPresenter($presenter);
        }

        return $this;
    }

    /**
     * Convert the entity, that is assigned to a activity, into a short presentation format.
     *
     * @param Activity $activity
     *
     * @return mixed
     */
    public function presentEntity(Activity $activity)
    {
        return $this->presenters[$activity->model_type]->present($activity->model);
    }

    /**
     * Get the activity type, that is used to refer to the entity in the history data structure.
     *
     * @param Activity $activity
     *
     * @return string
     */
    public function getType(Activity $activity)
    {
        return $activity->model_type;
    }
}
