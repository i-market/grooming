<?php

use App\Services;
use Bitrix\Iblock\Component\Tools;
use Core\Underscore as _;

$sections = Services::groupBySection($arResult['ID'], $arParams['PARENT_SECTION_CODE'], $arResult['ITEMS']);
foreach ($sections as &$sectionRef) {
    Tools::getFieldImageData($sectionRef, ['PICTURE'], Tools::IPROPERTY_ENTITY_ELEMENT);
}
if (_::isEmpty($sections)) {
    $sections = [[
        'NAME' => 'Все услуги',
        'ITEMS' => $arResult['ITEMS']
    ]];
}
$arResult['SECTIONS'] = $sections;
