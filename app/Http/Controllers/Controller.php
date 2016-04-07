<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function prepareCollection(
        $collectionName,
        Builder $builder,
        Request $request,
        $unknownFieldCallback = null,
        $pageSize = null
    ) {
        $orderByKey = $request->get('order-by');
        $direction = ($request->get('direction', 0)) ? 'desc' : 'asc';

        if (\Schema::hasColumn($builder->getModel()->getTable(), $orderByKey)) {
            $builder->orderBy($orderByKey, $direction);
        } else {
            if (is_callable($unknownFieldCallback)) {
                $return = $unknownFieldCallback($builder, $orderByKey, $direction);
                if (!is_null($return)) {
                    $orderByKey = $return;
                }
            }
        }

        $paginator = $builder->paginate($pageSize);

        $this->preserveIndexSet($collectionName, $orderByKey, $request, $paginator);

        return $paginator;
    }

    /**
     * @param $collectionName
     * @param Request $request
     * @param LengthAwarePaginator $paginator
     * @internal param $persons
     * @internal param $orderByKey
     */
    protected function preserveIndexSet($collectionName, $orderByKey, Request $request, LengthAwarePaginator $paginator)
    {
        session([
            $collectionName => [
                'page' => $paginator->currentPage(),
                'order-by' => $orderByKey,
                'direction' => $request->get('direction', 0)
            ]
        ]);
    }
}
