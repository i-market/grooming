<?php

use App\Contact;
use Core\Strings;
use Core\Underscore as _;

$lists = _::pick($arParams, ['EMAILS', 'PHONES', 'URLS']);
$filteredLists = array_map(function($list) {
    return array_filter($list, function($string) {
        return !Strings::isEmpty($string);
    });
}, $lists);
$latLng = Contact::parseLatlng($arParams['~LATLNG']);
$address = $arParams['~ADDRESS'];

$arResult = array_merge($filteredLists, [
    'ADDRESS' => $address,
    'HOURS_OF_OPERATION' => $arParams['~HOURS_OF_OPERATION'],
    'LATLNG' => $latLng,
    'URLS' => array_map(function($url) {
        return [
            'URL' => $url,
            'HOST' => parse_url($url, PHP_URL_HOST)
        ];
    }, $filteredLists['URLS']),
    'JSON' => json_encode(['address' => $address, 'latlng' => $latLng])
]);
$this->IncludeComponentTemplate();
