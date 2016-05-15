<?php

namespace App\History;

use Grimm\Activity;
use Illuminate\Database\Eloquent\Collection;

class HistoryTranspiler
{

    protected $history = [];
    /**
     * @var HistoryEntityTransformer
     */
    private $historyEntityTransformer;

    public function __construct(HistoryEntityTransformer $historyEntityTransformer)
    {

        $this->historyEntityTransformer = $historyEntityTransformer;
    }

    /**
     * Convert a collection of history entries into a displayable log
     *
     * @param Collection $activities
     *
     * @return array
     */
    public function transpileCollection(Collection $activities)
    {
        $this->clear();

        foreach ($activities as $activity) {
            $this->transpileEntry($activity);
        }

        return $this->history;
    }

    /**
     * Convert a single history entry.
     *
     * @param Activity $activity
     *
     * @return mixed
     */
    public function transpileEntry(Activity $activity)
    {
        $this->registerEntity($activity->model_type);
        $this->registerModel($activity);

        $data = $activity->log;

        $action = $data['action'];
        $method = $action . 'Activity';

        return call_user_func([$this, $method], $data, $activity->model_type, $activity->model_id);
    }

    /**
     * Clear the current history.
     */
    public function clear()
    {
        $this->history = [];
    }

    private function registerEntity($model_type)
    {
        if (!array_key_exists($model_type, $this->history)) {
            $this->history[$model_type] = [];
        }
    }

    /**
     * Handle a updating activity.
     *
     * @param $data
     * @param $type
     * @param $id
     */
    protected function updatingActivity($data, $type, $id)
    {
        $this->ensureLastHistoryElementIsUpdating($type, $id);

        $updatingEntry = &$this->history[$type][$id]['history'][count($this->history[$type][$id]['history']) - 1];

        foreach ($data['after'] as $field => $afterValue) {
            if (!isset($updatingEntry['data'][$field])) {
                $updatingEntry['data'][$field] = [
                    $data['before'][$field],
                ];
            }

            $updatingEntry['data'][$field][] = $afterValue;
        }
    }

    /**
     * Handle a creating activity.
     *
     * @param $data
     * @param $type
     * @param $id
     */
    protected function creatingActivity($data, $type, $id)
    {
        $this->history[$type][$id]['history'][] = $data;
    }

    /**
     * Handle a deleting activity.
     *
     * @param $data
     * @param $type
     * @param $id
     */
    protected function deletingActivity($data, $type, $id)
    {
        $this->history[$type][$id]['history'][] = $data;
    }

    /**
     * We have to create a new updating history entry, if there is no entry or the previous is a diff. action.
     *
     * @param $type
     * @param $id
     */
    protected function ensureLastHistoryElementIsUpdating($type, $id)
    {
        if (empty($this->history[$type][$id]['history']) || last($this->history[$type][$id]['history'])['action'] !== 'updating') {
            $this->history[$type][$id]['history'][] = [
                'action' => 'updating',
                'data' => [],
            ];
        }
    }

    private function registerModel(Activity $activity)
    {
        if (!isset($this->history[$activity->model_type][$activity->model_id])) {
            $this->history[$activity->model_type][$activity->model_id] = [
                'entity' => $this->historyEntityTransformer->presentEntity($activity),
                'history' => []
            ];
        }
    }
}
