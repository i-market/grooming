<?php

use App\Services;

$arResult['SECTIONS'] = Services::groupBySection($arResult['ID'], $arResult['ITEMS']);
