<?php

use App\PageProperty;
use Bitrix\Main\Page\Asset;
use Core\App;
use Core\Env;
use Core\View as v;

$asset = Asset::getInstance();
$asset->setJsToBody(true);
$styles = [
    'css/lib/normalize.min.css',
    'css/lib/jquery.fancybox.css',
    'css/lib/slick.css',
    'css/main.css'
];
$scripts = array_merge(
    [
        '//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js',
        'https://use.fontawesome.com/d5e5cdfb8c.js'
    ],
    array_map(function($path) {
        return v::asset($path);
    }, [
        'js/vendor/slick.min.js',
        'js/vendor/wow.min.js',
        'js/vendor/jquery.fancybox.pack.js',
        'js/script.js'
    ])
);
// use bitrix asset pipeline for non-dev environments
if (App::env() !== Env::DEV) {
    foreach ($styles as $path) {
        $asset->addCss(v::asset($path));
    }
    foreach ($scripts as $path) {
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
    <title><? $APPLICATION->ShowTitle() ?></title>
    <? if (App::env() === Env::DEV): ?>
        <? foreach ($styles as $path): ?>
            <link rel="stylesheet" media="screen" href="<?= v::asset($path) ?>">
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
<? v::showLayoutHeader(PageProperty::LAYOUT, 'base.twig', [
    'scripts' => App::env() === Env::DEV ? $scripts : []
]) ?>
