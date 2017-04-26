<?php

use Core\View;

$arResult['ITEMS'] = View::assocResized($arResult['ITEMS'], 'DETAIL_PICTURE', ['width' => 400, 'height' => 400]);

