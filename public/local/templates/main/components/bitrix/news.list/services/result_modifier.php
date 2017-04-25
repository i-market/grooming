<?php

use Core\Underscore as _;
use App\Services;
use Bitrix\Iblock\Component\Tools;

$includeOrphans = true;
$sections = Services::groupBySection($arResult['ID'], $arParams['PARENT_SECTION_CODE'], $arResult['ITEMS'], $includeOrphans);
foreach ($sections as &$sectionRef) {
    Tools::getFieldImageData($sectionRef, ['PICTURE'], Tools::IPROPERTY_ENTITY_ELEMENT);
}
$tagElements = function($item, $indent = 0) {
    return array_merge($item, [
        'TYPE' => 'ELEMENT',
        'INDENT' => $indent
    ]);
};
$tableRows = function($section) use ($tagElements) {
    $elementRows = array_map($tagElements, $section['ITEMS']);
    $rows = array_reduce($section['SECTIONS'], function($rows, $subsection) use ($tagElements) {
        $sectionRow = _::set($subsection, 'TYPE', 'SECTION');
        $elementRows = array_map(function($item) use ($tagElements) {
            return $tagElements($item, 1);
        }, $subsection['ITEMS']);
        return array_merge($rows, _::prepend($elementRows, $sectionRow));
    }, []);
    return array_merge($elementRows, $rows);
};
$arResult['SECTIONS'] = array_map(function($section) use ($tableRows) {
    return _::set($section, 'TABLE_ROWS', $tableRows($section));
}, $sections);

// TODO refactor wildcard table properties
$props = _::remove($arResult['ITEMS'][0]['PROPERTIES'], '*');
$arResult['TABLE_PROPERTIES'] = _::mapValues($props, function($prop) {
    return _::pick($prop, ['CODE', 'NAME']);
});
