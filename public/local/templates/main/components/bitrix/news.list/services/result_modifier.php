<?php

use Core\Underscore as _;
use App\Services;
use Bitrix\Iblock\Component\Tools;

$includeOrphans = true;
$sections = Services::groupBySection($arResult['ID'], $arParams['PARENT_SECTION_CODE'], $arResult['ITEMS'], $includeOrphans);
foreach ($sections as &$sectionRef) {
    Tools::getFieldImageData($sectionRef, ['PICTURE'], Tools::IPROPERTY_ENTITY_ELEMENT);
}
$arResult['SECTIONS'] = $sections;

// TODO refactor wildcard table properties
$props = _::remove($arResult['ITEMS'][0]['PROPERTIES'], '*');
$arResult['TABLE_PROPERTIES'] = _::mapValues($props, function($prop) {
    return _::pick($prop, ['CODE', 'NAME']);
});
