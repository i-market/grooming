<?php
use Core\Underscore as _;
use Core\View as v;
?>
<? $this->SetViewTarget('bitrix:search.page:form') ?>
<?$APPLICATION->IncludeComponent(
    "bitrix:search.form",
    "search",
    Array(
        "PAGE" => v::path('search'),
        "USE_SUGGEST" => "N",
        "QUERY" => $arResult['REQUEST']['QUERY']
    ),
    null,
    array('HIDE_ICONS' => 'Y')
);?>
<? $this->EndViewTarget() ?>
<? if (_::isEmpty($arResult['SEARCH'])): ?>
    <p>
        По вашему запросу ничего не найдено.
    </p>
<? else: ?>
    <? foreach ($arResult['SEARCH'] as $item): ?>
        <a href="<?= $item['URL'] ?>"><h4 class="title"><?= $item['TITLE_FORMATED'] ?></h4></a>
        <p>
            <?= $item['BODY_FORMATED'] ?>
        </p>
    <? endforeach ?>
<? endif ?>
