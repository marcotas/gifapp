<?php

function create($class, $attributes = [], $states = [])
{
    return factory($class)->states($states)->create($attributes);
}

function create_list($class, int $times, array $attributes = [], $states = [])
{
    $items = factory($class, $times)->states($states)->create($attributes);
    if (is_array($items)) {
        return collect($items);
    }

    return $items;
}

function make($class, $attributes = [], $states = [])
{
    return factory($class)->states($states)->make($attributes);
}

function make_list($class, int $times, array $attributes = [])
{
    $items = factory($class, $times)->make($attributes);
    if (is_array($items)) {
        return collect($items);
    }

    return $items;
}

function raw($class, $attributes = [], $states = [])
{
    return factory($class)->states($states)->raw($attributes);
}

function raw_list($class, int $times, array $attributes = [])
{
    $items = factory($class, $times)->raw($attributes);
    if (is_array($items)) {
        return collect($items);
    }

    return $items;
}
