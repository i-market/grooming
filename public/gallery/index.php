<?
use App\App;
use App\HeroBanner;
use App\Iblock;
use App\PageProperty;
use Bex\Tools\Iblock\IblockTools;
use Core\View as v;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Галерея");
$APPLICATION->SetPageProperty(PageProperty::LAYOUT, ['base.twig', function() {
    return App::layoutContext([
        'hero_banner' => HeroBanner::GALLERY_CODE
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
            		"PATH" => v::includedArea('gallery/top_heading.php')
            	)
            ); ?>
        </strong>
        <div class="inner_text editable-area">
            <? $APPLICATION->IncludeComponent(
            	"bitrix:main.include",
            	"",
            	Array(
            		"AREA_FILE_SHOW" => "file",
            		"PATH" => v::includedArea('gallery/top_body.php')
            	)
            ); ?>
        </div>
        <div class="tab_links">
            <span data-tabLinks="gallery_grooming">Груминг</span>
            <span data-tabLinks="hotel" class="some2">Гостиница</span>
            <span data-tabLinks="store">Зоомагазин</span>
            <? //<span data-tabLinks="taxi">Зоотакси</span> ?>
        </div>
        <div class="tab_blocks">
            <? foreach (['gallery_grooming', 'hotel', 'store', 'taxi'] as $sectionCode): ?>
                <div data-tabContent="<?= $sectionCode ?>">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "gallery_tab",
                        Array(
                            "ACTIVE_DATE_FORMAT" => "j F Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "DISPLAY_DATE" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array("DETAIL_PICTURE"),
                            "FILTER_NAME" => "",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => IblockTools::find(Iblock::CONTENT_TYPE, Iblock::IMAGES)->id(),
                            "IBLOCK_TYPE" => Iblock::CONTENT_TYPE,
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => PHP_INT_MAX,
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => '',
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => $sectionCode,
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "PROPERTY_CODE" => array("", ""),
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SORT_BY1" => "ACTIVE_FROM",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER1" => "DESC",
                            "SORT_ORDER2" => "ASC"
                        )
                    ); ?>
                </div>
            <? endforeach ?>
        </div>
    </div>
</section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>