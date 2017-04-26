<?php

use App\Util;

$arResult['ITEMS'] = Util::resizeForGallery($arResult['ITEMS'], ['width' => 300, 'height' => 300]);
