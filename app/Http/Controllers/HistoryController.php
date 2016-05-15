<?php

namespace App\Http\Controllers;

use App\History\HistoryTranspiler;
use Carbon\Carbon;
use Grimm\Activity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;

class HistoryController extends Controller
{

    public function since(Request $request, HistoryTranspiler $historyTranspiler)
    {
        $date = new Carbon($request->get('date', date('d.m.Y')));

        /** @var Collection $activities */
        $activities = Activity::query()->with(['model' => function($q) {
            $q->withTrashed();
        }])->orderBy('model_type', 'model_id', 'created_at')->where('created_at', '>=',
            $date)->get();

        $history = $historyTranspiler->transpileCollection($activities);

        return response()->json([
            'data' => [
                'since' => $date->toRfc822String(),
                'history' => $history
            ]
        ]);
    }
}
