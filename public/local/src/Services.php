<?php

namespace App;

use Bex\Tools\Iblock\IblockTools;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use CIBlockElement;
use Core\Strings;
use Core\Nullable as nil;
use Core\View as v;
use Core\Underscore as _;
use Core\Iblock as ib;
use Bitrix\Iblock\Component\Tools;

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
    // TODO refactor
    static function activeServiceTypes($sectionCode = null) {
        $iblocks = self::serviceTypes();
        return array_filter($iblocks, function($iblock) use ($sectionCode) {
            $filter = [
                'IBLOCK_SECTION.IBLOCK_ID' => $iblock['ID'],
                'IBLOCK_SECTION.ACTIVE' => 'Y'
            ];
            if ($sectionCode !== null) {
                $filter[] = ['LOGIC' => 'OR',
                    // e.g. dogs
                    ['IBLOCK_SECTION.CODE' => $sectionCode],
                    // e.g. dogs → гигиеническая стрижка
                    ['IBLOCK_SECTION.PARENT_SECTION.CODE' => $sectionCode],
                ];
            }
            $count = SectionElementTable::getCount($filter);
            return $count > 0;
        });
    }

    static function serviceTypeImages($sectionCode) {
        $el = new CIBlockElement();
        $elements = ib::collectElements($el->GetList([], [
            'IBLOCK_ID' => IblockTools::find(Iblock::CONTENT_TYPE, Iblock::IMAGES)->id(),
            'ACTIVE' => 'Y',
            'IBLOCK_SECTION.PARENT_SECTION.CODE' => 'services',
            'IBLOCK_SECTION.CODE' => $sectionCode,
        ]));
        foreach ($elements as &$elementRef) {
            Tools::getFieldImageData($elementRef, ['DETAIL_PICTURE'], Tools::IPROPERTY_ENTITY_ELEMENT);
        }
        return $elements;
    }

    private static function inflate($roots, $groups) {
        return array_map(function($section) use ($groups) {
            return _::set($section, 'SECTIONS', self::inflate($groups[$section['ID']], $groups));
        }, $roots);
    }

    static function groupBySection($iblockId, $parentSectionCode, $services) {
        $sections = _::keyBy('ID', SectionTable::query()
            ->setSelect(['ID', 'CODE', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL'])
            ->setFilter(['IBLOCK_ID' => $iblockId])
            ->exec()->fetchAll()
        );
        $parentSectionMaybe = _::find($sections, function($section) use ($parentSectionCode) {
            return $section['CODE'] === $parentSectionCode;
        });
        $localRootDepth = intval(_::get($parentSectionMaybe, 'DEPTH_LEVEL', 0));
        foreach ($services as $service) {
            $sections[$service['IBLOCK_SECTION_ID']]['ITEMS'][] = $service;
        }
        $sections = array_filter($sections, function($section) use ($localRootDepth) {
            // TODO better filtering of non-relevant sections
            return intval($section['DEPTH_LEVEL']) > $localRootDepth;
        });
        // group by parent section
        $groups = _::groupBy($sections, 'IBLOCK_SECTION_ID');
        $roots = $groups[_::get($parentSectionMaybe, 'ID')];
        $ret = self::inflate($roots, $groups);
        return $ret;
    }

    static function renderServiceTypesGrid($sectionCode) {
        $images = _::keyBy('CODE', self::serviceTypeImages($sectionCode));
        $serviceTypes = array_map(function($serviceType) use ($sectionCode, $images) {
            return array_merge($serviceType, [
                'LINK' => v::path(join('/', ['grooming', $sectionCode, $serviceType['CODE']])),
                'IMAGE' => $images[$serviceType['CODE']]
            ]);
        }, self::activeServiceTypes($sectionCode));
        return v::twig()->render(v::partial('services/service_types_grid.twig'), [
            'service_types' => $serviceTypes
        ]);
    }

    static function renderGallerySection($sectionCode) {
        return v::twig()->render(v::partial('services/gallery_section.twig'), [
            'gallery' => self::renderGallery($sectionCode)
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
                "PARENT_SECTION_CODE" => 'gallery_grooming_'.$sectionCode,
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