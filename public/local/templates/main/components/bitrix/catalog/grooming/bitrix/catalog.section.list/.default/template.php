<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use App\Services;
use Core\View as v;
?>

<? // TODO is there a more idiomatic way to set the title here? ?>
<? $APPLICATION->SetTitle($arResult['SECTION']['NAME']) ?>

<section class="services_for_dogs" data-anchor="next">
    <div class="wrap">
        <strong class="heading"><h2><? $APPLICATION->ShowTitle() ?></h2></strong>
        <div class="grid">
            <? foreach ($arResult['SECTIONS'] as $section): ?>
                <? // TODO editing actions ?>
                <a href="<?= $section['SECTION_PAGE_URL'] ?>" class="col col_3 item">
                    <div class="img">
                        <? // TODO resize ?>
                        <img src="<?= $section['PICTURE']['SRC'] ?>" alt="<?= $section['PICTURE']['ALT'] ?>">
                        <div class="hidden">
                            <p>Подробнее<br>об услуге</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <p><?= $section['NAME'] ?></p>
                    </div>
                </a>
            <? endforeach ?>
        </div>
    </div>
</section>
<?= Services::renderGallerySection($arResult['SECTION']['CODE']) ?>

