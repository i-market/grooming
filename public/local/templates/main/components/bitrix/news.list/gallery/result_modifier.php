<?php

use Core\Underscore as _;

$dimensions = [
    'PREVIEW' => ['width' => 360, 'height' => 360],
    'MODAL' => ['width' => 1920, 'height' => 1080]
];
$arResult['ITEMS'] = array_map(function($item) use ($dimensions) {
    return _::update($item, 'DETAIL_PICTURE', function($pic) use ($dimensions) {
        $resized = _::mapValues($dimensions, function($dim) use ($pic) {
            return CFile::ResizeImageGet($pic, $dim);
        });
        return _::set($pic, 'RESIZED', $resized);
    });
}, $arResult['ITEMS']);
