<?php

use Core\Underscore as _;

$arResult['COLUMNS'] = _::splitAt($arResult, ceil(count($arResult) / 2));
