<?php

if (!function_exists('getAvatarUrl')) {
    function getAvatarUrl($name, $size = 100)
    {
        $name = urlencode($name);
        return "https://eu.ui-avatars.com/api/?name={$name}&size={$size}&color=38bdf8&background=f0f9ff";
    }
}
