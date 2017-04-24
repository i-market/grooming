<?php

use Core\Underscore as _;

// TODO refactor wildcard table properties
$props = _::remove($arResult['ITEMS'][0]['PROPERTIES'], '*');
$arResult['TABLE_PROPERTIES'] = _::mapValues($props, function($prop) {
    return _::pick($prop, ['CODE', 'NAME']);
});