<?php

use Core\View as v;

$html = v::twig()->render(v::partial('breadcrumbs.twig'), ['items' => $arResult]);
$this->AddViewContent('bitrix:breadcrumb:top', $html);
return '';