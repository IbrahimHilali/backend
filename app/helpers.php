<?php

if (!function_exists('sort_link')) {
    /**
     * @param $url
     * @param $key
     */
    function sort_link($url, $key) {
        $currentSort = request()->get('order-by', 'name');

        $queryParams = [];
        if ($currentSort != $key) {
            $queryParams = ['order-by' => $key, 'direction' => 0];
        } else {
            $direction = intval(request()->get('direction', 0));
            $queryParams = ['order-by' => $key, 'direction' => 1-$direction];
        }

        return url($url) . '?' . http_build_query($queryParams);
    }
}