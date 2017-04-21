<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use App\Services;
use Core\View as v;

global $APPLICATION;

$sectionCode = 'dogs';
$menuItems = array_map(function($iblock) use ($sectionCode) {
    $link = v::path(join('/', ['grooming', $sectionCode, $iblock['CODE']]));
    return [$iblock['NAME'], $link, [], [], ''];
}, Services::activeServiceTypes($sectionCode));

$aMenuLinks = array_merge($aMenuLinks, $menuItems);