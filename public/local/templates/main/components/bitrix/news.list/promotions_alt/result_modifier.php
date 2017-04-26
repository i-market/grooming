<?php

use Core\View;

$arResult['ITEMS'] = View::assocResized($arResult['ITEMS'], 'PREVIEW_PICTURE', ['width' => 400, 'height' => 300]);

