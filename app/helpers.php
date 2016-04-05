<?php

if (!function_exists('sort_link')) {
    /**
     * @param $url
     * @param $key
     * @return string
     */
    function sort_link($url, $key)
    {
        $currentSort = request()->get('order-by', 'name');

        if ($currentSort != $key) {
            $queryParams = ['order-by' => $key, 'direction' => 0];
        } else {
            $direction = intval(request()->get('direction', 0));
            if ($direction == 1) {
                return url($url);
            }
            $queryParams = ['order-by' => $key, 'direction' => 1 - $direction];
        }

        return url($url) . '?' . http_build_query($queryParams);
    }
}

if (!function_exists('sort_arrow')) {
    function sort_arrow($key)
    {
        $currentSort = request()->get('order-by', 'name');

        if ($currentSort === $key) {
            $direction = intval(request()->get('direction', 0));
            if ($direction == 0) {
                return '<i class="fa fa-caret-up"></i>';
            } else {
                return '<i class="fa fa-caret-down"></i>';
            }
        }

        return '';
    }
}

if (!function_exists('checked')) {
    /**
     * @param $field
     * @param $value
     * @return string
     */
    function checked($field, $value)
    {

        if ($field == $value) {
            return ' checked="checked"';
        }

        return '';
    }
}

if (!function_exists('checked_if')) {
    /**
     * @param $condition
     * @return string
     */
    function checked_if($condition)
    {
        return ($condition) ? ' checked="checked"' : '';
    }
}

if (!function_exists('selected_if')) {
    /**
     * @param $condition
     * @return string
     */
    function selected_if($condition)
    {
        return ($condition) ? ' selected="selected"' : '';
    }
}

if (!function_exists('referrer_url')) {
    function referrer_url($key, $dest)
    {
        $params = session($key);
        if (!$params) {
            return $dest;
        }

        $params = http_build_query($params);

        return $dest . '?' . $params;
    }
}