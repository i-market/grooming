<?php

use Core\Underscore as _;
use App\Services;
use Bitrix\Iblock\Component\Tools;

$includeOrphans = true;
$tabs = Services::groupBySection($arResult['ID'], $arParams['PARENT_SECTION_CODE'], $arResult['ITEMS']);
foreach ($tabs as &$tabRef) {
    Tools::getFieldImageData($tabRef, ['PICTURE'], Tools::IPROPERTY_ENTITY_ELEMENT);
}
$tagElements = function($item, $indent = 0) {
    return array_merge($item, [
        'TYPE' => 'ELEMENT',
        'INDENT' => $indent
    ]);
};
$tableRows = function($tab) use ($tagElements) {
    $elementRows = array_map($tagElements, _::get($tab, 'ITEMS', []));
    $groups = _::get($tab, 'SECTIONS', []);
    $rows = array_reduce($groups, function($rows, $group) use ($tagElements) {
        if (isset($group['ITEMS'])) {
            $groupRow = _::set($group, 'TYPE', 'SECTION');
            $elementRows = array_map(function($item) use ($tagElements) {
                return $tagElements($item, 1);
            }, $group['ITEMS']);
            return array_merge($rows, _::prepend($elementRows, $groupRow));
        } else {
            return [];
        }
    }, []);
    return array_merge($elementRows, $rows);
};
$arResult['SECTIONS'] = array_reduce($tabs, function($acc, $tab) use ($tableRows) {
    $rows = $tableRows($tab);
    // TODO refactor: filter in `groupBySection`
    // filter tabs with no items
    if (!_::isEmpty($rows)) {
        return _::append($acc, _::set($tab, 'TABLE_ROWS', $rows));
    } else {
        return $acc;
    }
}, []);

// TODO refactor wildcard table properties
$props = _::remove($arResult['ITEMS'][0]['PROPERTIES'], '*');
$arResult['TABLE_PROPERTIES'] = _::mapValues($props, function($prop) {
    return _::pick($prop, ['CODE', 'NAME']);
});
