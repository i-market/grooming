<?php

namespace App;

use Bex\Tools\Iblock\IblockTools;

class HeroBanner {
    const HOMEPAGE_CODE = 'Главная страница';
    const STORE_CODE = 'Магазин';
    const TAXI_CODE = 'Зоотакси';
    const GROOMING_CODE = 'Груминг';
    const SERVICES_DOGS_CODE = 'Услуги для собак';
    const HOTEL_CODE = 'Гостиница';
    const PROMOTIONS_CODE = 'Акции';

    static function render($elementCode) {
        global $APPLICATION;
        ob_start();
        $APPLICATION->IncludeComponent(
            "bitrix:photo.detail",
            "hero_banner",
            Array(
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "BROWSER_TITLE" => "-",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "DETAIL_URL" => "",
                "ELEMENT_CODE" => $elementCode,
                "ELEMENT_ID" => "",
                "ELEMENT_SORT_FIELD" => "sort",
                "ELEMENT_SORT_ORDER" => "asc",
                "FIELD_CODE" => array("PREVIEW_TEXT"),
                "IBLOCK_ID" => IblockTools::find(Iblock::CONTENT_TYPE, Iblock::HERO_BANNERS)->id(),
                "IBLOCK_TYPE" => Iblock::CONTENT_TYPE,
                "MESSAGE_404" => "",
                "META_DESCRIPTION" => "-",
                "META_KEYWORDS" => "-",
                "PROPERTY_CODE" => array("LINE_CLASS"),
                "SECTION_CODE" => "",
                "SECTION_ID" => "",
                "SECTION_URL" => "",
                "SET_LAST_MODIFIED" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N"
            )
        );
        return ob_get_clean();
    }
}
