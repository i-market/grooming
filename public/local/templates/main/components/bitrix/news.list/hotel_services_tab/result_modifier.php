<?php

use Core\Underscore as _;

$sectionCode = $arParams['PARENT_SECTION_CODE'];
$headings = [
    'dogs' => 'В стоимость номера для собак входят:',
    'cats' => 'В стоимость номера для кошек входят:',
    'rodents' => 'В стоимость номера для грызунов входят:'
];
$arResult['SECTION_DESCRIPTION'] = [
    'HEADING' => $headings[$sectionCode],
    'TEXT' => $arResult['SECTION']['PATH'][0]['DESCRIPTION']
];
$dimensions = [
    'PREVIEW' => ['width' => 300, 'height' => 300],
    'MODAL' => ['width' => 1920, 'height' => 1080]
];
$arResult['ITEMS'] = array_map(function($item) use ($dimensions) {
    $key = 'DISPLAY_PROPERTIES.PHOTOS.FILE_VALUE';
    return _::update($item, $key, function($pics) use ($dimensions) {
        // bitrix is weird
        if (isset($pics['ID'])) {
            $pics = [$pics];
        }
        return array_map(function($pic) use ($dimensions) {
            $resized = _::mapValues($dimensions, function($dim) use ($pic) {
                return CFile::ResizeImageGet($pic, $dim);
            });
            return _::set($pic, 'RESIZED', $resized);
        }, $pics);
    });
}, $arResult['ITEMS']);

