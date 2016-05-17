<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Schema;

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

        if (Schema::hasColumn($builder->getModel()->getTable(), $orderByKey)) {
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

        $this->preserveIndexSet($collectionName, $request);

        return $paginator;
    }

    /**
     * @param         $collectionName
     * @param Request $request
     *
     * @return mixed
     */
    protected function preserveIndexSet($collectionName, Request $request)
    {
        return session([
            $collectionName => $request->all(),
        ]);
    }

    /**
     * Creates the prefix selection UI for a given prefix of a list of prefixes.
     *
     * @param $prefix
     * @param $prefixes
     */
    protected function preparePrefixDisplay($prefix, $prefixes)
    {
        view()->composer('partials.prefixSelection', function ($view) use ($prefix, $prefixes) {
            $firstCharacter = Str::substr($prefix, 0, 1);
            $secondCharacter = Str::substr($prefix, 1);

            $navigationPrefixes = [];

            foreach ($prefixes as $prefix) {
                $prefix = $this->preparePrefix($prefix->prefix);

                $prefixStart = Str::substr($prefix, 0, 1);
                $prefixWithoutStart = Str::substr($prefix, 1);

                if ($prefixStart) {
                    if (!isset($navigationPrefixes[$prefixStart])) {
                        $navigationPrefixes[$prefixStart] = [];
                    }

                    if ($prefixWithoutStart) {
                        $navigationPrefixes[$prefixStart][] = $prefixWithoutStart;
                    }
                }
            }
            $view->with(compact('firstCharacter', 'secondCharacter', 'navigationPrefixes'));
        });
    }

    protected function preparePrefix($prefix)
    {
        $prefix = Str::lower($prefix);

        $search = ['ä', 'ö', 'ü'];
        $replace = ['a', 'o', 'u'];

        $prefix = str_replace($search, $replace, $prefix);

        return Str::ucfirst($prefix);
    }
}
