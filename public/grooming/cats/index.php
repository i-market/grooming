<?
use App\App;
use App\HeroBanner;
use App\PageProperty;
use App\Services;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Услуги для кошек");
$APPLICATION->SetPageProperty(PageProperty::LAYOUT, ['base.twig', function() {
    return App::layoutContext([
        'hero_banner' => HeroBanner::GROOMING_CODE
    ]);
}]);
$sectionCode = 'cats';
?>

<section class="services_for_dogs" data-anchor="next">
    <div class="wrap">
        <strong class="heading"><h2><? $APPLICATION->ShowTitle() ?></h2></strong>
        <?= Services::renderServiceTypesGrid($sectionCode) ?>
    </div>
</section>
<?= Services::renderGallerySection($sectionCode) ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>