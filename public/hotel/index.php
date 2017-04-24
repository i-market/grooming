<?
use App\App;
use App\HeroBanner;
use App\Hotel;
use App\PageProperty;
use Core\View as v;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Гостиница");
$APPLICATION->SetPageProperty(PageProperty::LAYOUT, ['hotel.twig', function() {
    return App::layoutContext([
        'hero_banner' => HeroBanner::HOTEL_CODE
    ]);
}]);
?>

<section class="shares--page" data-anchor="next">
    <div class="wrap">
        <strong class="heading">
            <? $APPLICATION->IncludeComponent(
            	"bitrix:main.include",
            	"",
            	Array(
            		"AREA_FILE_SHOW" => "file",
            		"PATH" => v::includedArea('hotel/top_heading.php')
            	)
            ); ?>
        </strong>
        <div class="inner_text inner_text_mb editable-area">
            <? $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => v::includedArea('hotel/top_body.php')
                )
            ); ?>
        </div>
    </div>
</section>
<section class="haircut hotel-options" data-anchor="next">
    <div class="tab_links tab_links--cat">
        <div class="wrap">
            <span data-tabLinks="cats">Кошки</span>
            <span data-tabLinks="dogs" class="some2">Собаки</span>
            <span data-tabLinks="rodents">Грызуны</span>
        </div>
    </div>
    <div class="tab_blocks tab_blocks--cat">
        <div class="wrap">
            <? foreach (['cats', 'dogs', 'rodents'] as $tabId): ?>
                <?= Hotel::renderHotelServicesTab($tabId) ?>
            <? endforeach ?>
        </div>
    </div>
</section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>