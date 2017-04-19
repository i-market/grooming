<?php

use Core\View;

$arResult['ITEMS'] = View::assocResized($arResult['ITEMS'], 'PREVIEW_PICTURE', ['width' => 350, 'height' => 350]);