<?php

use Core\Underscore as _;
?>
<? if ($arResult['FILE'] !== ''): ?>
    <? $content = file_get_contents($arResult['FILE']) ?>
    <? if (!_::isEmpty($content)): ?>
        <section class="simple-text-section">
            <div class="wrap">
                <? // not .editable-area ?>
                <div class="simple_text">
                    <?= $content ?>
                </div>
            </div>
        </section>
    <? endif ?>
<? endif ?>
