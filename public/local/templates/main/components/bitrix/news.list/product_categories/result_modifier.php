<?php

use Core\View;
use Core\Underscore as _;

$items = View::assocResized($arResult['ITEMS'], 'PREVIEW_PICTURE', ['width' => 405, 'height' => 405]);
$classes = _::cycle([
    'right bottom',
    'left top',
    'right bottom',
    'left top',
    'right top',
    'right top'
]);
$styles = _::cycle([
    'background: rgba(153, 153, 153, 0.6)',
    'background: rgba(204, 106, 0, 0.6)'
]);
$arResult['ITEMS'] = _::mapValues($items, function($item) use ($classes, $styles) {
    $ret = array_merge($item, [
        'CLASS' => $classes->current(),
        'STYLE' => $styles->current()
    ]);
    // TODO refactor?
    $classes->next();
    $styles->next();
    return $ret;
});
