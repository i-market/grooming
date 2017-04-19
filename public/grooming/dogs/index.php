<?
use App\App;
use App\HeroBanner;
use App\PageProperty;
use App\Services;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Услуги для собак");
$APPLICATION->SetPageProperty(PageProperty::LAYOUT, ['base.twig', function() {
    return App::layoutContext([
        'hero_banner' => HeroBanner::SERVICES_DOGS_CODE
    ]);
}]);
$animalSectionCode = 'dogs';
?>

<section class="services_for_dogs" data-anchor="next">
    <div class="wrap">
        <strong class="heading"><h2><? $APPLICATION->ShowTitle() ?></h2></strong>
        <?= Services::renderServiceTypesGrid($animalSectionCode) ?>
    </div>
</section>
<?= Services::renderGallerySection($animalSectionCode) ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>