<?php

use App\Services;

$arResult['SECTIONS'] = Services::groupBySection($arResult['ID'], $arParams['PARENT_SECTION_CODE'], $arResult['ITEMS']);
