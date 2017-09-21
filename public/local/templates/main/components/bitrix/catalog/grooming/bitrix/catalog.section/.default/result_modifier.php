<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\SectionTable;
use Bitrix\Iblock\SectionElementTable;
use Core\Underscore as _;
use Core\Strings as str;
use App\Services;
use Bitrix\Iblock\Component\Tools;

// TODO refactor, optimize

$inflate = function($roots, $groups) use (&$inflate) {
    return array_map(function($section) use (&$inflate, $groups) {
        return _::set($section, 'SECTIONS', $inflate($groups[$section['ID']], $groups));
    }, $roots);
};

$rels = SectionElementTable::getList()->fetchAll();
$sectionsByElement = _::map(_::groupBy($rels, 'IBLOCK_ELEMENT_ID'), function($rels) {
    return _::pluck($rels, 'IBLOCK_SECTION_ID');
});
$sections = _::keyBy('ID', SectionTable::query()
    ->setSelect(['ID', 'CODE', 'NAME', 'IBLOCK_SECTION_ID', 'DESCRIPTION', 'PICTURE'])
    ->setFilter(['IBLOCK_ID' => $arResult['IBLOCK_ID']])
    ->exec()->fetchAll()
);
foreach ($arResult['ITEMS'] as $item) {
    foreach (_::get($sectionsByElement, $item['ID'], []) as $id) {
        $sections[$id]['ITEMS'][] = $item;
    }
}
// group by parent section
$groups = _::groupBy($sections, 'IBLOCK_SECTION_ID');
$roots = $groups[$arResult['ID']];
$tabs = $inflate($roots, $groups);

$currSection = _::keyBy('ID', $groups[$arResult['IBLOCK_SECTION_ID']])[$arResult['ID']];
$orphans = array_filter($currSection['ITEMS'], function($item) use ($sectionsByElement, $arResult) {
    return $sectionsByElement[$item['ID']] === [$arResult['ID']];
});
if (!_::isEmpty($orphans)) {
    // handle tabless elements
    $tabs[] = [
        'NAME' => 'Другие услуги',
        'ITEMS' => $orphans,
        'SECTIONS' => []
    ];
}

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
    // filter tabs without items
    if (!_::isEmpty($rows)) {
        return _::append($acc, _::set($tab, 'TABLE_ROWS', $rows));
    } else {
        return $acc;
    }
}, []);

// TODO refactor wildcard table properties
$props = _::remove($arResult['ITEMS'][0]['PROPERTIES'], '*');
$tableProps = _::keyBy('CODE', _::mapValues($props, function($prop) {
    return _::pick($prop, ['CODE', 'NAME']);
}));
$nonEmptyProps = array_unique(_::flatMap($arResult['ITEMS'], function($item) {
    $nonEmptyValues = array_filter(_::pluck($item['PROPERTIES'], 'VALUE'), function($val) {
        return !str::isEmpty($val);
    });
    return array_keys($nonEmptyValues);
}));
$arResult['TABLE_PROPERTIES'] = _::map($nonEmptyProps, function($code) use ($tableProps) {
    return ['CODE' => $code, 'NAME' => $tableProps[$code]['NAME']];
});
//$displayFields = Services::fieldsToDisplay(intval($arParams['IBLOCK_ID']));
$displayFields = [];
$arResult['DISPLAY_FIELDS'] = $displayFields;
$arResult['COLS_COUNT'] = count($displayFields) + count($arResult['TABLE_PROPERTIES']);
