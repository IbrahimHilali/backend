<?php

if (!function_exists('sort_link')) {
    /**
     * @param $url
     * @param $key
     * @return string
     */
    function sort_link($url, $key) {
        $currentSort = request()->get('order-by', 'name');

        if ($currentSort != $key) {
            $queryParams = ['order-by' => $key, 'direction' => 0];
        } else {
            $direction = intval(request()->get('direction', 0));
            $queryParams = ['order-by' => $key, 'direction' => 1-$direction];
        }

        return url($url) . '?' . http_build_query($queryParams);
    }
}

if (!function_exists('checked')) {
    /**
     * @param $url
     * @param $key
     * @return string
     */
    function checked($field, $value) {

        if ($field == $value) {
            return ' checked="checked';
        }

        return '';
    }
}