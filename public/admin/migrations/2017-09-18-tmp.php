<?php

use App\Iblock;
use Bex\Tools\Iblock\IblockTools;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use Core\Nullable as nil;
use Core\Underscore as _;
use Core\Strings as str;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("migration");

$tasks = nil::get(nil::map($_REQUEST['tasks'], function($s) {
    return explode(',', $s);
}), []);
if ($USER->IsAdmin() && !_::isEmpty($tasks)) {
    if (in_array('migrate', $tasks)) {
        // модельная стрижка
        $sectionId = 722;
        $iblockId = IblockTools::find(Iblock::SERVICES_TYPE, 'fancy_haircut')->id();
        $allElements = _::keyBy('ID', ElementTable::getList(['filter' => ['IBLOCK_ID' => $iblockId]])->fetchAll());
        $allRels = SectionElementTable::getList()->fetchAll();
        $relsByElement = _::groupBy($allRels, 'IBLOCK_ELEMENT_ID');
        $elements = _::reduce($relsByElement, function($acc, $rels, $elementId) use ($allElements, $sectionId) {
            $hasRel = _::matchesAny($rels, function($rel) use ($sectionId) {
                return $rel['IBLOCK_SECTION_ID'] == $sectionId;
            });
            return $hasRel ? _::append($acc, $allElements[$elementId]) : $acc;
        }, []);
        $results = array_map(function($element) use ($sectionId, $relsByElement) {
            $el = new CIBlockElement();
            $currSections = _::pluck($relsByElement[$element['ID']], 'IBLOCK_SECTION_ID');
            $result = $el->Update($element['ID'], [
                'IBLOCK_SECTION_ID' => $sectionId,
                'IBLOCK_SECTION' => $currSections
            ]);
            return [$element['ID'], $result, $el->LAST_ERROR];
        }, $elements);
    }
    echo '<pre>';
    var_export([count($results), $results]);
    echo '</pre>';
} else {
    echo 'missing param';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
