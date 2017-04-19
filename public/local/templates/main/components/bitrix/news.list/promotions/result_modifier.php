<?php

use Core\View;

$arResult['ITEMS'] = View::assocResized($arResult['ITEMS'], 'PREVIEW_PICTURE', ['width' => 405, 'height' => 405]);