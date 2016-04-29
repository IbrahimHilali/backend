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
        $otherParams = request()->except(['order-by', 'direction']);

        if ($currentSort != $key) {
            $queryParams = ['order-by' => $key, 'direction' => 0];
        } else {
            $direction = intval(request()->get('direction', 0));
            if ($direction == 1) {
                $queryParams = [];
            } else {
                $queryParams = ['order-by' => $key, 'direction' => 1 - $direction];
            }
        }

        $queryParams = $queryParams + $otherParams;

        if (count($queryParams) > 0) {
            return url($url) . '?' . http_build_query($queryParams);
        } else {
            return url($url);
        }
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
    function referrer_url($key, $dest, $hashtag='')
    {
        $params = session($key);
        if (!$params) {
            return $dest . $hashtag;
        }

        $params = http_build_query($params);

        return $dest . '?' . $params . $hashtag;
    }
}

if (!function_exists('model_type')) {
    function model_type($model, $pluralize=true) {
        $reflection = new ReflectionClass($model);
        $type = strtolower(last(explode('\\', $reflection->getShortName())));

        if ($pluralize) {
            return str_plural($type);
        }

        return $type;
    }
}

if (!function_exists('field_name')) {
    function field_name($field, $model) {
        $langFile = (is_string($model)) ? $model : model_type($model);
        return trans($langFile . '.' . $field);
    }
}
