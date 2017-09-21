<?php

use App\Iblock;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;
use Core\Nullable as nil;
use Core\Underscore as _;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("migration");

$tasks = nil::get(nil::map($_REQUEST['tasks'], function($s) {
    return explode(',', $s);
}), []);
if ($USER->IsAdmin() && !_::isEmpty($tasks)) {
    $results = [];
    if (in_array('migrate', $tasks)) {
        \Bitrix\Main\Loader::includeModule('iblock');
        $conn = Application::getConnection();
        $conn->startTransaction();
        try {
            $rels = SectionElementTable::getList()->fetchAll();
            $sectionsByElement = _::map(_::groupBy($rels, 'IBLOCK_ELEMENT_ID'), function($rels) {
                return _::pluck($rels, 'IBLOCK_SECTION_ID');
            });
            $iblockId = \Bex\Tools\Iblock\IblockTools::find(Iblock::SERVICES_TYPE, Iblock::SERVICES)->id();
            $el = new CIBlockElement();
            $elements = Core\Iblock::collectElements($el->GetList([], ['IBLOCK_ID' => $iblockId]));

            // TODO hardcoded ids

            // dogs Модельная стрижка
            $from = '773'; // Модельная стрижка
            $to = '771'; // Другие услуги
            $filtered = array_filter($elements, function($item) use ($sectionsByElement, $from) {
                $sections = $sectionsByElement[$item['ID']];
                return in_array($from, $sections);
            });
            foreach ($filtered as $item) {
                $sections = $sectionsByElement[$item['ID']];
                $sectionIds = _::without($sections, $from);
                if (count($sections) <= 2) {
                    $sectionIds[] = $to;
                }
                $results[] = $el->SetElementSection($item['ID'], $sectionIds);
            }

//            $conn->rollbackTransaction();
            $conn->commitTransaction();
        } catch (Exception $e) {
            $conn->rollbackTransaction();
            throw $e;
        }
    }
    echo '<pre>';
    var_export($results);
    echo '</pre>';
} else {
    echo 'something is missing';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
