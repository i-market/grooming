<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Core\Underscore as _;
use Core\NewsListLike;
?>
<section class="haircut" data-anchor="next">
    <div class="wrap">
        <strong class="heading"><h2><?= $arResult['NAME'] ?></h2></strong>
    </div>
    <? if (count($arResult['SECTIONS']) > 1): ?>
        <div class="tab_links">
            <div class="wrap">
                <? foreach ($arResult['SECTIONS'] as $section): ?>
                    <span data-tabLinks="<?= 'section-'.$section['ID'] ?>"><?= $section['NAME'] ?></span>
                <? endforeach ?>
            </div>
        </div>
    <? endif ?>
    <div class="tab_blocks">
        <div class="wrap">
            <? foreach ($arResult['SECTIONS'] as $section): ?>
                <div data-tabContent="<?= 'section-'.$section['ID'] ?>">
                    <div class="inner">
                        <div class="top">
                            <? if ($section['PICTURE']): ?>
                                <div class="img">
                                    <img src="<?= $section['PICTURE']['SRC'] ?>" alt="<?= $section['PICTURE']['ALT'] ?>">
                                </div>
                            <? endif ?>
                            <div class="description editable-area"><?= $section['DESCRIPTION'] ?></div>
                        </div>
                        <? if (!_::isEmpty($section['TABLE_ROWS'])): ?>
                            <div class="wrap_table">
                                <table>
                                    <thead>
                                    <tr>
                                        <? foreach ($arResult['DISPLAY_FIELDS'] as $field): ?>
                                            <td><?= $field === 'NAME' ? 'Название услуги' : '' ?></td>
                                        <? endforeach ?>
                                        <? foreach ($arResult['TABLE_PROPERTIES'] as $prop): ?>
                                            <td><?= $prop['NAME'] ?></td>
                                        <? endforeach ?>
                                    </tr>
                                    </thead>
                                    <tbody class="show_items">
                                    <? foreach ($section['TABLE_ROWS'] as $row): ?>
                                        <? if ($row['TYPE'] === 'ELEMENT'): ?>
                                            <? $item = $row ?>
                                            <tr id="<?= NewsListLike::addEditingActions($item, $this) ?>" class="<?= $row['INDENT'] > 0 ? 'indent-'.$row['INDENT'] : '' ?>">
                                                <? foreach ($arResult['DISPLAY_FIELDS'] as $field): ?>
                                                    <td><?= $row[$field] ?></td>
                                                <? endforeach ?>
                                                <? foreach ($arResult['TABLE_PROPERTIES'] as $prop): ?>
                                                    <td><?= $item['PROPERTIES'][$prop['CODE']]['VALUE'] ?></td>
                                                <? endforeach ?>
                                            </tr>
                                        <? elseif ($row['TYPE'] === 'SECTION'): ?>
                                            <tr>
                                                <td><?= $row['NAME'] ?></td>
                                                <? foreach (_::range(0, $arResult['COLS_COUNT'] - 2) as $x): ?>
                                                    <td></td>
                                                <? endforeach ?>
                                            </tr>
                                        <? endif ?>
                                    <? endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="wrap_btn">
                                <span class="more_table_items" style="display: none">Еще</span>
                            </div>
                        <? endif ?>
                    </div>
                </div>
            <? endforeach ?>
        </div>
    </div>
</section>