<?
use App\App;
use App\HeroBanner;
use App\Iblock;
use App\PageProperty;
use Bex\Tools\Iblock\IblockTools;
use Core\View as v;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Зоотакси");
$APPLICATION->SetPageProperty(PageProperty::LAYOUT, ['base.twig', App::layoutContext([
    'hero_banner' => HeroBanner::TAXI_CODE
])]);
?>

<section class="taxi_advantages" data-anchor="next">
  <div class="wrap wrap--pages">
    <? $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => v::includedArea('taxi/advantages_header.php')
        )
    ); ?>
    <? $APPLICATION->IncludeComponent(
    	"bitrix:news.list",
    	"taxi_advantages",
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
    		"IBLOCK_ID" => IblockTools::find(Iblock::CONTENT_TYPE, Iblock::TAXI_ADVANTAGES)->id(),
    		"IBLOCK_TYPE" => Iblock::CONTENT_TYPE,
    		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
    		"INCLUDE_SUBSECTIONS" => "Y",
    		"MESSAGE_404" => "",
    		"NEWS_COUNT" => 5, // картинки images/0_.png есть только для пяти элементов
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
</section>
<section class="our_taxi">
  <div class="wrap wrap--pages">
    <strong class="heading"><h2>Наше такси</h2></strong>
    <p class="text">Наше такси оборудовано необходимым оборудованием, а наши водители безопасно и вовремя доставят Ваших питомцев.</p>
    <div class="grid">
      <div class="col col_3">
        <img src="images/pic_6.jpg" alt="">
      </div>
      <div class="col col_3">
        <img src="images/pic_7.jpg" alt="">
      </div>
      <div class="col col_3">
        <img src="images/pic_8.jpg" alt="">
      </div>
    </div>
  </div>
</section>
<section class="taxi_tarif">
  <div class="wrap wrap--pages">
    <strong class="heading"><h2>Тарифы</h2></strong>
    <div class="grid">
      <div class="item col col_5">
        <div class="top">
          <p>от <span>500</span>р</p>
        </div>
        <div class="ico">
          <img src="images/taxi_ico.svg" alt="">
        </div>
        <p class="text">Поездка в
          <br>пределах
          <br>20 км</p>
        <a class="order" href="#">Заказать</a>
      </div>
      <div class="item col col_5">
        <div class="top">
          <p>от <span>1500</span>р</p>
        </div>
        <div class="ico">
          <img src="images/taxi_ico_2.svg" alt="">
        </div>
        <p class="text">Поездка в
          <br>пределах
          <br>40 км</p>
        <a class="order" href="#">Заказать</a>
      </div>
      <div class="item col col_5">
        <div class="top">
          <p>от <span>800</span>р</p>
        </div>
        <div class="ico">
          <img src="images/taxi_ico.svg" alt="">
        </div>
        <p class="text">Ожидание
          <br>для поездки
          <br>туда-обратно</p>
        <a class="order" href="#">Заказать</a>
      </div>
      <div class="item col col_5">
        <div class="top">
          <p>от <span>2500</span>р</p>
        </div>
        <div class="ico">
          <img src="images/taxi_ico_2.svg" alt="">
        </div>
        <p class="text">Перевозка
          <br>животного без
          <br>хозяина</p>
        <a class="order" href="#">Заказать</a>
      </div>
      <div class="item col col_5">
        <div class="top">
          <p>от <span>3000</span>р</p>
        </div>
        <div class="ico">
          <img src="images/taxi_ico.svg" alt="">
        </div>
        <p class="text">Поездка
          <br>свыше
          <br>40 км</p>
        <a class="order" href="#">Заказать</a>
      </div>
    </div>
    <div class="allert_text"><span>*</span>При перевозке в ночное время с 23:00-06:00 осуществляется доплата 500 руб. к общей сумме заказа.</div>
    <div class="simple_text">
      <p>Идейные соображения высшего порядка, а также постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании соответствующий условий активизации. Идейные соображения высшего порядка, а также новая модель организационной деятельности играет важную роль в формировании модели развития. Не следует, однако забывать, что постоянное информационно-пропагандистское обеспечение нашей деятельности требуют определения и уточнения систем массового участия.</p>
      <p>Значимость этих проблем настолько очевидна, что укрепление и развитие структуры способствует подготовки и реализации направлений прогрессивного развития. Не следует, однако забывать, что сложившаяся структура организации обеспечивает широкому кругу (специалистов) участие в формировании модели развития. Значимость этих проблем настолько очевидна, что консультация с широким активом влечет за собой процесс внедрения и модернизации направлений прогрессивного развития. Повседневная практика показывает, что реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании систем массового участия.</p>
      <p>Таким образом консультация с широким активом влечет за собой процесс внедрения и модернизации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же реализация намеченных плановых заданий способствует подготовки и реализации форм развития. Идейные соображения высшего порядка, а также постоянное информационно-пропагандистское обеспечение нашей деятельности требуют от нас анализа соответствующий условий активизации.</p>
    </div>
  </div>
</section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>