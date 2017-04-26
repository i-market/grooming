<?php

use App\Util;

$arResult['ITEMS'] = Util::resizeForGallery($arResult['ITEMS'], ['width' => 360, 'height' => 360]);
