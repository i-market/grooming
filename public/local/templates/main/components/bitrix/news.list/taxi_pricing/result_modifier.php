<?php

use Core\Underscore as _;

$arResult['ITEMS'] = array_map(function($item) {
    $cost = _::get($item, 'PROPERTIES.COST.VALUE');
    $formattedCost = preg_replace_callback('/\d+/', function($matches) {
        return '<span>'.$matches[0].'</span>';
    }, $cost);
    return _::set($item, 'FORMATTED_COST', $formattedCost);
}, $arResult['ITEMS']);