<?php

namespace App;

use Bex\Tools\Iblock\IblockTools;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Core\View as v;

class Services {
    static function serviceTypes() {
        return IblockTable::query()
            ->setSelect(['ID', 'NAME', 'CODE'])
            ->setFilter(['IBLOCK_TYPE_ID' => Iblock::SERVICES_TYPE])
            ->exec()->fetchAll();
    }

    /**
     * returns non-empty (have at least one active element) service types
     */
    static function activeServiceTypes($animalSectionCode = null) {
        $iblocks = self::serviceTypes();
        return array_filter($iblocks, function($iblock) use ($animalSectionCode) {
            $filter = ['IBLOCK_ID' => $iblock['ID'], 'ACTIVE' => 'Y'];
            if ($animalSectionCode !== null) {
                $filter['IBLOCK_SECTION.CODE'] = $animalSectionCode;
            }
            $count = ElementTable::getCount($filter);
            return $count > 0;
        });
    }

    static function renderServiceTypesGrid($animalSectionCode) {
        $serviceTypes = array_map(function($serviceType) use ($animalSectionCode) {
            return array_merge($serviceType, [
                // TODO refactor: hardcoded uri
                'LINK' => '/grooming/'.$animalSectionCode.'/'.$serviceType['CODE'].'/',
                // TODO fetch the image
                'IMAGE' => []
            ]);
        }, self::activeServiceTypes($animalSectionCode));
        return v::twig()->render(v::partial('services/service_types_grid.twig'), [
            'service_types' => $serviceTypes
        ]);
    }
    
    static function renderGallerySection($animalSectionCode) {
        return v::twig()->render(v::partial('services/gallery_section.twig'), [
            'gallery' => self::renderGallery($animalSectionCode)
        ]);
    }

    static function renderGallery($sectionCode) {
        global $APPLICATION;
        ob_start();
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "gallery_tab",
            Array(
                "ACTIVE_DATE_FORMAT" => "j F Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("DETAIL_PICTURE"),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => IblockTools::find(Iblock::CONTENT_TYPE, Iblock::IMAGES)->id(),
                "IBLOCK_TYPE" => Iblock::CONTENT_TYPE,
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => PHP_INT_MAX,
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => '',
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => $sectionCode,
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC"
            )
        );
        return ob_get_clean();
    }


}