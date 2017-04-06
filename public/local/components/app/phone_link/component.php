<?php

use App\Util;

$normalized = Util::normalizePhoneNumber($arParams['PHONE']);
$arResult = [
    'FORMATTED' => $arParams['PHONE'],
    'NORMALIZED' => $normalized,
    'LINK' => 'tel:'.$normalized
];
$this->IncludeComponentTemplate();
