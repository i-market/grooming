<?
use App\App;
use App\HeroBanner;
use App\Iblock;
use App\PageProperty;
use Bex\Tools\Iblock\IblockTools;
use Core\View as v;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Груминг");
$APPLICATION->SetPageProperty(PageProperty::LAYOUT, ['base.twig', App::layoutContext([
    'hero_banner' => HeroBanner::GROOMING_CODE
])]);
?>

<section class="service--page" data-anchor="next">
    <div class="wrap">
        <strong class="heading">
            <? $APPLICATION->IncludeComponent(
            	"bitrix:main.include",
            	"",
            	Array(
            		"AREA_FILE_SHOW" => "file",
            		"PATH" => v::includedArea('grooming/service_heading.php')
            	)
            ); ?>
        </strong>
        <? $APPLICATION->IncludeComponent(
        	"bitrix:news.list",
        	"grooming_service",
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
        		"FIELD_CODE" => array("", ""),
        		"FILTER_NAME" => "",
        		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
        		"IBLOCK_ID" => IblockTools::find(Iblock::CONTENT_TYPE, Iblock::GROOMING_SERVICE)->id(),
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
        		"PARENT_SECTION_CODE" => "",
        		"PREVIEW_TRUNCATE_LEN" => "",
        		"PROPERTY_CODE" => array("ICON", "LINK"),
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
</section>
<section class="before_after">
    <strong class="heading">
        <? $APPLICATION->IncludeComponent(
        	"bitrix:main.include",
        	"",
        	Array(
        		"AREA_FILE_SHOW" => "file",
        		"PATH" => v::includedArea('grooming/gallery_heading.php')
        	)
        ); ?>
    </strong>
    <? $APPLICATION->IncludeComponent(
    	"bitrix:news.list",
    	"grooming_gallery",
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
    		"PARENT_SECTION_CODE" => "grooming_gallery",
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
</section>
<section class="why_us why_us--pages">
    <div class="wrap wrap_why_us">
        <strong class="heading">
            <? $APPLICATION->IncludeComponent(
            	"bitrix:main.include",
            	"",
            	Array(
            		"AREA_FILE_SHOW" => "file",
            		"PATH" => v::includedArea('grooming/why_us_heading.php')
            	)
            ); ?>
        </strong>
        <div class="grid slider_why_us">
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".2s">
                <div class="ico">
                    <img src="images/ico_8.png" alt="">
                </div>
                <strong>Квалифицированный персонал</strong>
                <p>Все наши сотрудники имеют сертификаты и дипломы, подтверждающие их высокий уровень квалификации и навыков работы с животными.</p>
            </div>
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".5s">
                <div class="ico">
                    <img src="images/ico_9.png" alt="">
                </div>
                <strong>Профессиональная косметика</strong>
                <p>Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику.</p>
            </div>
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay=".8s">
                <div class="ico">
                    <img src="images/ico_10.png" alt="">
                </div>
                <strong>Современное оборудование</strong>
                <p>Наличие лучшего оборудования позволяет нам ухаживать за Вашими питомцами на самом высоком уровне.</p>
            </div>
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay="1.1s">
                <div class="ico">
                    <img src="images/ico_11.png" alt="">
                </div>
                <strong>Индивидуальный подход</strong>
                <p>Каждый домашний питомец индивидуален. Наши сотрудники, имея большой опыт работы с четвероногими любимцами, умеют найти общий язык с каждым из них.</p>
            </div>
            <div class="item wow fadeInDown" data-wow-duration=".6s" data-wow-delay="1.4s">
                <div class="ico">
                    <img src="images/ico_12.png" alt="">
                </div>
                <strong>Привлекательные цены</strong>
                <p>Наша компания предлагает широкий выбор пакетов услуг по уходу за Вашим питомцем. Высокое качество по доступным ценам – кредо нашей компании.</p>
            </div>
        </div>
    </div>
</section>
<div class="dots dots_why_us dots_why_us--pages"></div>
<div class="more_info">
    <img src="images/dog_cat.jpg" alt="">
    <div class="plus plus1">+
        <div class="dd_plus">
            <span class="title">Уши</span>
            <p class="text">Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.</p>
        </div>
    </div>
    <div class="plus plus2">+
        <div class="dd_plus">
            <span class="title">Уши</span>
            <p class="text">Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.</p>
        </div>
    </div>
    <div class="plus plus3">+
        <div class="dd_plus">
            <span class="title">Уши</span>
            <p class="text">Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.</p>
        </div>
    </div>
    <div class="plus plus4">+
        <div class="dd_plus">
            <span class="title">Уши</span>
            <p class="text">Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.</p>
        </div>
    </div>
    <div class="plus plus5">+
        <div class="dd_plus">
            <span class="title">Уши</span>
            <p class="text">Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.</p>
        </div>
    </div>
    <div class="plus plus6">+
        <div class="dd_plus">
            <span class="title">Уши</span>
            <p class="text">Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.</p>
        </div>
    </div>
    <div class="plus plus7">+
        <div class="dd_plus">
            <span class="title">Уши</span>
            <p class="text">Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.</p>
        </div>
    </div>
    <div class="plus plus8">+
        <div class="dd_plus">
            <span class="title">Уши</span>
            <p class="text">Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.</p>
        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>