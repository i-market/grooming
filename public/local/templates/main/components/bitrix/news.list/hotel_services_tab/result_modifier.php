<?php

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
