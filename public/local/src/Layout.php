<?php

namespace App;

class Layout {
    static function renderHeaderMenu() {
        global $APPLICATION;
        ob_start();
        $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "header",
            Array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "left",
                "DELAY" => "N",
                "MAX_LEVEL" => "2",
                "MENU_CACHE_GET_VARS" => array(""),
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "top",
                "USE_EXT" => "Y"
            )
        );
        return ob_get_clean();
    }
}