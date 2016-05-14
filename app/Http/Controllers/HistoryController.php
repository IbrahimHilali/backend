<?php

namespace App\Http\Controllers;

use Grimm\Activity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;

class HistoryController extends Controller
{

    public function since(Request $request)
    {
        $date = $request->get('date');

        /** @var Collection $activities */
        $activities = Activity::query()->orderBy('model_type', 'model_id', 'created_at')->where('created_at', '>=', $date)->get();

        $models = [];

        $activities->each(function($el) use ($models) {
            if (!array_key_exists($el->model_type, $models)) {
                $models[$el->model_type] = [];
            }

            foreach ($el->log['after'] as $field => $afterValue) {
                if (!isset($models[$el->model_type][$el->model_id][$field])) {
                    $models[$el->model_type][$el->model_id][$field] = [
                        $el->log['before'][$field],
                    ];
                }

                $models[$el->model_type][$el->model_id][$field][] = $afterValue;
            }

        });
    }
}
