<?php

use Core\View;

$items = View::assocResized($arResult['ITEMS'], 'PREVIEW_PICTURE', ['width' => 405, 'height' => 405]);
