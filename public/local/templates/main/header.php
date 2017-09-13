<?php

use App\App;
use App\PageProperty;
use Bitrix\Main\Page\Asset;
use Core\View as v;

$assets = App::assets();
$asset = Asset::getInstance();
$asset->setJsToBody(true);
if (App::useBitrixAsset()) {
    foreach ($assets['styles'] as $path) {
        $asset->addCss($path);
    }
    foreach ($assets['scripts'] as $path) {
        $asset->addJs($path);
    }
}
?>
<!doctype html>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <? $APPLICATION->ShowHead() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title><? $APPLICATION->AddBufferContent(function() use (&$APPLICATION) {
        return $APPLICATION->GetProperty('title') ?: 'Грумелье. '.$APPLICATION->GetTitle();
    }) ?></title>
    <? if (!App::useBitrixAsset()): ?>
        <? foreach ($assets['styles'] as $path): ?>
            <link rel="stylesheet" media="screen" href="<?= $path ?>">
        <? endforeach ?>
    <? endif ?>
    <!--[if gte IE 9]>
    <style type="text/css">
        .gradient {
            filter: none;
        }
    </style>
    <![endif]-->
</head>
<body>
<? $APPLICATION->ShowPanel() ?>
<?
// renders empty string, puts html into the bitrix view
// hide icons, otherwise bitrix editing thingy is rendered in the wrong place on the page
$APPLICATION->IncludeComponent(
    "bitrix:breadcrumb",
    "top",
    array(
        "PATH" => "",
        "SITE_ID" => App::SITE_ID,
        "START_FROM" => "0"
    ),
    null,
    array('HIDE_ICONS' => 'Y')
);
?>
<?
// see `local/templates/main/layouts` directory
v::showLayoutHeader(PageProperty::LAYOUT, 'default.twig', function() {
    return App::layoutContext();
})
?>
