<?php

function setting($key)
{
    return array_get(app('settings'), $key);
}