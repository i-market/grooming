<?php

use App\Services;
use Bitrix\Iblock\Component\Tools;

$sections = Services::groupBySection($arResult['ID'], $arParams['PARENT_SECTION_CODE'], $arResult['ITEMS']);
foreach ($sections as &$sectionRef) {
    Tools::getFieldImageData($sectionRef, ['PICTURE'], Tools::IPROPERTY_ENTITY_ELEMENT);
}
$arResult['SECTIONS'] = $sections;
