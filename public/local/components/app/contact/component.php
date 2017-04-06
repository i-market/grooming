<?php

use Core\Strings;
use Core\Underscore as _;

$lists = _::pick($arParams, ['EMAILS', 'PHONES', 'URLS']);
$filteredLists = array_map(function($list) {
    return array_filter($list, function($string) {
        return !Strings::isEmpty($string);
    });
}, $lists);

$arResult = array_merge($filteredLists, [
    'ADDRESS' => $arParams['~ADDRESS'],
    'HOURS_OF_OPERATION' => $arParams['~HOURS_OF_OPERATION'],
    'URLS' => array_map(function($url) {
        return [
            'URL' => $url,
            'HOST' => parse_url($url, PHP_URL_HOST)
        ];
    }, $filteredLists['URLS'])
]);
$this->IncludeComponentTemplate();
