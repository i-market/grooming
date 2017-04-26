<?php

use Core\View;
use Core\Underscore as _;

$items = View::assocResized($arResult['ITEMS'], 'PREVIEW_PICTURE', ['width' => 405, 'height' => 405]);
$classes = [
    'right bottom',
    'left top',
    'right bottom',
    'left top',
    'right top',
    'right top'
];
$styles = [
    'background: rgba(153, 153, 153, 0.6)',
    'background: rgba(204, 106, 0, 0.6)'
];
$arResult['ITEMS'] = _::mapValues($items, function($item, $idx) use ($classes, $styles) {
    return array_merge($item, [
        'CLASS' => $classes[$idx % count($classes)],
        'STYLE' => $styles[$idx % count($styles)]
    ]);
});
