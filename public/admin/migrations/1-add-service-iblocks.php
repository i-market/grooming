<?php

use Core\Nullable as nil;
use Core\Underscore as _;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("migration");

$tasks = nil::get(nil::map($_REQUEST['tasks'], function($s) {
    return explode(',', $s);
}), []);
if ($USER->IsAdmin() && !_::isEmpty($tasks)) {
    $iblockFields = function($code, $name) {
        return array (
            'ACTIVE' => 'Y',
            'NAME' => $name,
            'CODE' => $code,
            'LIST_PAGE_URL' => '#SITE_DIR#/grooming/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/grooming/',
            'CANONICAL_PAGE_URL' => '',
            'INDEX_ELEMENT' => 'Y',
            'IBLOCK_TYPE_ID' => \App\Iblock::SERVICES_TYPE,
            'LID' =>
                array (
                    0 => \App\App::SITE_ID,
                ),
            'SORT' => '500',
            'PICTURE' =>
                array (
                    'name' => '',
                    'type' => '',
                    'tmp_name' => '',
                    'error' => 4,
                    'size' => 0,
                    'del' => NULL,
                    'MODULE_ID' => 'iblock',
                ),
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'SECTION_CHOOSER' => 'L',
            'LIST_MODE' => '',
            'FIELDS' =>
                array (
                    'IBLOCK_SECTION' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' =>
                                array (
                                    'KEEP_IBLOCK_SECTION_ID' => 'N',
                                ),
                        ),
                    'ACTIVE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => 'Y',
                        ),
                    'ACTIVE_FROM' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'ACTIVE_TO' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'SORT' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'NAME' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'PREVIEW_PICTURE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' =>
                                array (
                                    'WIDTH' => '',
                                    'HEIGHT' => '',
                                    'METHOD' => 'resample',
                                    'COMPRESSION' => '95',
                                    'WATERMARK_FILE' => '',
                                    'WATERMARK_FILE_ALPHA' => '',
                                    'WATERMARK_FILE_POSITION' => 'tl',
                                    'WATERMARK_TEXT' => '',
                                    'WATERMARK_TEXT_FONT' => '',
                                    'WATERMARK_TEXT_COLOR' => '',
                                    'WATERMARK_TEXT_SIZE' => '',
                                    'WATERMARK_TEXT_POSITION' => 'tl',
                                ),
                        ),
                    'PREVIEW_TEXT_TYPE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => 'text',
                        ),
                    'PREVIEW_TEXT_TYPE_ALLOW_CHANGE' =>
                        array (
                            'DEFAULT_VALUE' => 'Y',
                        ),
                    'PREVIEW_TEXT' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'DETAIL_PICTURE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' =>
                                array (
                                    'WIDTH' => '',
                                    'HEIGHT' => '',
                                    'METHOD' => 'resample',
                                    'COMPRESSION' => '95',
                                    'WATERMARK_FILE' => '',
                                    'WATERMARK_FILE_ALPHA' => '',
                                    'WATERMARK_FILE_POSITION' => 'tl',
                                    'WATERMARK_TEXT' => '',
                                    'WATERMARK_TEXT_FONT' => '',
                                    'WATERMARK_TEXT_COLOR' => '',
                                    'WATERMARK_TEXT_SIZE' => '',
                                    'WATERMARK_TEXT_POSITION' => 'tl',
                                ),
                        ),
                    'DETAIL_TEXT_TYPE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => 'text',
                        ),
                    'DETAIL_TEXT_TYPE_ALLOW_CHANGE' =>
                        array (
                            'DEFAULT_VALUE' => 'Y',
                        ),
                    'DETAIL_TEXT' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'XML_ID' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'CODE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' =>
                                array (
                                    'TRANS_LEN' => '100',
                                    'TRANS_CASE' => 'L',
                                    'TRANS_SPACE' => '-',
                                    'TRANS_OTHER' => '-',
                                    'TRANS_EAT' => 'Y',
                                ),
                        ),
                    'TAGS' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'SECTION_NAME' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'SECTION_PICTURE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' =>
                                array (
                                    'WIDTH' => '',
                                    'HEIGHT' => '',
                                    'METHOD' => 'resample',
                                    'COMPRESSION' => '95',
                                    'WATERMARK_FILE' => '',
                                    'WATERMARK_FILE_ALPHA' => '',
                                    'WATERMARK_FILE_POSITION' => 'tl',
                                    'WATERMARK_TEXT' => '',
                                    'WATERMARK_TEXT_FONT' => '',
                                    'WATERMARK_TEXT_COLOR' => '',
                                    'WATERMARK_TEXT_SIZE' => '',
                                    'WATERMARK_TEXT_POSITION' => 'tl',
                                ),
                        ),
                    'SECTION_DESCRIPTION_TYPE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => 'text',
                        ),
                    'SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE' =>
                        array (
                            'DEFAULT_VALUE' => 'Y',
                        ),
                    'SECTION_DESCRIPTION' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'SECTION_DETAIL_PICTURE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' =>
                                array (
                                    'WIDTH' => '',
                                    'HEIGHT' => '',
                                    'METHOD' => 'resample',
                                    'COMPRESSION' => '95',
                                    'WATERMARK_FILE' => '',
                                    'WATERMARK_FILE_ALPHA' => '',
                                    'WATERMARK_FILE_POSITION' => 'tl',
                                    'WATERMARK_TEXT' => '',
                                    'WATERMARK_TEXT_FONT' => '',
                                    'WATERMARK_TEXT_COLOR' => '',
                                    'WATERMARK_TEXT_SIZE' => '',
                                    'WATERMARK_TEXT_POSITION' => 'tl',
                                ),
                        ),
                    'SECTION_XML_ID' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' => '',
                        ),
                    'SECTION_CODE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                            'DEFAULT_VALUE' =>
                                array (
                                    'TRANS_LEN' => '100',
                                    'TRANS_CASE' => 'L',
                                    'TRANS_SPACE' => '-',
                                    'TRANS_OTHER' => '-',
                                    'TRANS_EAT' => 'Y',
                                ),
                        ),
                    'LOG_SECTION_ADD' =>
                        array (
                            'IS_REQUIRED' => 'N',
                        ),
                    'LOG_SECTION_EDIT' =>
                        array (
                            'IS_REQUIRED' => 'N',
                        ),
                    'LOG_SECTION_DELETE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                        ),
                    'LOG_ELEMENT_ADD' =>
                        array (
                            'IS_REQUIRED' => 'N',
                        ),
                    'LOG_ELEMENT_EDIT' =>
                        array (
                            'IS_REQUIRED' => 'N',
                        ),
                    'LOG_ELEMENT_DELETE' =>
                        array (
                            'IS_REQUIRED' => 'N',
                        ),
                ),
            'ELEMENTS_NAME' => 'Элементы',
            'ELEMENT_NAME' => 'Элемент',
            'ELEMENT_ADD' => 'Добавить элемент',
            'ELEMENT_EDIT' => 'Изменить элемент',
            'ELEMENT_DELETE' => 'Удалить элемент',
            'SECTION_PAGE_URL' => '#SITE_DIR#/grooming/',
            'INDEX_SECTION' => 'Y',
            'SECTIONS_NAME' => 'Разделы',
            'SECTION_NAME' => 'Раздел',
            'SECTION_ADD' => 'Добавить раздел',
            'SECTION_EDIT' => 'Изменить раздел',
            'SECTION_DELETE' => 'Удалить раздел',
            'RIGHTS_MODE' => 'S',
            'GROUP_ID' =>
                array (
                    2 => 'R',
                    1 => 'X',
                    3 => '',
                    4 => '',
                ),
            'IPROPERTY_TEMPLATES' =>
                array (
                    'SECTION_META_TITLE' => '',
                    'SECTION_META_KEYWORDS' => '',
                    'SECTION_META_DESCRIPTION' => '',
                    'SECTION_PAGE_TITLE' => '',
                    'ELEMENT_META_TITLE' => '',
                    'ELEMENT_META_KEYWORDS' => '',
                    'ELEMENT_META_DESCRIPTION' => '',
                    'ELEMENT_PAGE_TITLE' => '',
                    'SECTION_PICTURE_FILE_ALT' => '',
                    'SECTION_PICTURE_FILE_TITLE' => '',
                    'SECTION_PICTURE_FILE_NAME' => '',
                    'SECTION_DETAIL_PICTURE_FILE_ALT' => '',
                    'SECTION_DETAIL_PICTURE_FILE_TITLE' => '',
                    'SECTION_DETAIL_PICTURE_FILE_NAME' => '',
                    'ELEMENT_PREVIEW_PICTURE_FILE_ALT' => '',
                    'ELEMENT_PREVIEW_PICTURE_FILE_TITLE' => '',
                    'ELEMENT_PREVIEW_PICTURE_FILE_NAME' => '',
                    'ELEMENT_DETAIL_PICTURE_FILE_ALT' => '',
                    'ELEMENT_DETAIL_PICTURE_FILE_TITLE' => '',
                    'ELEMENT_DETAIL_PICTURE_FILE_NAME' => '',
                ),
            'VERSION' => 1,
        );
    };
    $propFields = function($iblockId, $code, $name) {
        return array (
            'NAME' => $name,
            'SORT' => 500,
            'CODE' => $code,
            'MULTIPLE' => 'N',
            'IS_REQUIRED' => 'N',
            'ACTIVE' => 'Y',
            'USER_TYPE' => false,
            'PROPERTY_TYPE' => 'S',
            'IBLOCK_ID' => $iblockId,
            'FILE_TYPE' => '',
            'LIST_TYPE' => 'L',
            'ROW_COUNT' => 1,
            'COL_COUNT' => 30,
            'LINK_IBLOCK_ID' => 0,
            'DEFAULT_VALUE' => '',
            'USER_TYPE_SETTINGS' =>
                array (
                ),
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'MULTIPLE_CNT' => 5,
            'HINT' => '',
            'VALUES' =>
                array (
                ),
            'SECTION_PROPERTY' => 'Y',
            'SMART_FILTER' => 'N',
            'DISPLAY_TYPE' => false,
            'DISPLAY_EXPANDED' => 'N',
            'FILTER_HINT' => '',
        );
    };
    $sectionFields = function($iblockId, $code, $name) {
        return array (
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $iblockId,
            'NAME' => $name,
            'SORT' => '500',
            'CODE' => $code,
            'PICTURE' =>
                array (
                    'name' => NULL,
                    'type' => NULL,
                    'tmp_name' => NULL,
                    'error' => 4,
                    'size' => 0,
                ),
            'DETAIL_PICTURE' =>
                array (
                    'name' => NULL,
                    'type' => NULL,
                    'tmp_name' => NULL,
                    'error' => 4,
                    'size' => 0,
                ),
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
            'IPROPERTY_TEMPLATES' =>
                array (
                    'SECTION_META_TITLE' => '',
                    'SECTION_META_KEYWORDS' => '',
                    'SECTION_META_DESCRIPTION' => '',
                    'SECTION_PAGE_TITLE' => '',
                    'ELEMENT_META_TITLE' => '',
                    'ELEMENT_META_KEYWORDS' => '',
                    'ELEMENT_META_DESCRIPTION' => '',
                    'ELEMENT_PAGE_TITLE' => '',
                    'SECTION_PICTURE_FILE_ALT' => '',
                    'SECTION_PICTURE_FILE_TITLE' => '',
                    'SECTION_PICTURE_FILE_NAME' => '',
                    'SECTION_DETAIL_PICTURE_FILE_ALT' => '',
                    'SECTION_DETAIL_PICTURE_FILE_TITLE' => '',
                    'SECTION_DETAIL_PICTURE_FILE_NAME' => '',
                    'ELEMENT_PREVIEW_PICTURE_FILE_ALT' => '',
                    'ELEMENT_PREVIEW_PICTURE_FILE_TITLE' => '',
                    'ELEMENT_PREVIEW_PICTURE_FILE_NAME' => '',
                    'ELEMENT_DETAIL_PICTURE_FILE_ALT' => '',
                    'ELEMENT_DETAIL_PICTURE_FILE_TITLE' => '',
                    'ELEMENT_DETAIL_PICTURE_FILE_NAME' => '',
                ),
        );
    };
    $breedProp = ['code' => 'BREED', 'name' => 'Название породы'];
    $priceProp = ['code' => 'PRICE', 'name' => 'Стоимость (руб.)'];
    $priceWithTrimming = ['code' => 'PRICE_WITH_TRIMMING', 'name' => 'Стоимость (руб.) с триммингом'];
    $durationProp = ['code' => 'DURATION', 'name' => 'Время'];
    $commentProp = ['code' => 'COMMENT', 'name' => 'Комментарии'];
    $iblocks = [
        [
            'code' => 'haircut',
            'name' => 'Стрижка',
            'props' => [$breedProp, $priceProp, $durationProp]
        ],
        [
            'code' => 'fancy_haircut',
            'name' => 'Модельная стрижка',
            'props' => [$breedProp, $priceProp, $priceWithTrimming, $durationProp, $commentProp]
        ],
        [
            'code' => 'bathing',
            'name' => 'Купание',
            'props' => [$breedProp, $priceProp, $durationProp]
        ],
        [
            'code' => 'additional',
            'name' => 'Дополнительные услуги',
            'props' => [$priceProp, $durationProp]
        ],
        [
            'code' => 'without_appointment',
            'name' => 'Услуги без записи',
            'props' => [$priceProp, $durationProp]
        ],
        [
            'code' => 'creative',
            'name' => 'Креативные услуги',
            'props' => [$priceProp, $durationProp]
        ]
    ];
    $sections = [
        [
            'code' => 'dogs',
            'name' => 'Услуги для собак'
        ],
        [
            'code' => 'cats',
            'name' => 'Услуги для кошек'
        ]
    ];
    $results = [];
    if (in_array('iblocks', $tasks)) {
        $results[] = 'iblocks task';
        try {
            foreach ($iblocks as $iblock) {
                $ib = new CIBlock();
                $iblockId = $ib->Add($iblockFields($iblock['code'], $iblock['name']));
                $results[] = ['iblock', $iblockId, $ib->LAST_ERROR];
                foreach ($iblock['props'] as $prop) {
                    $p = new CIBlockProperty();
                    $fields = $propFields($iblockId, $prop['code'], $prop['name']);
                    $results[] = ['prop', $p->Add($fields), $p->LAST_ERROR];
                }
                foreach ($sections as $section) {
                    $sec = new CIBlockSection();
                    $fields = $sectionFields($iblockId, $section['code'], $section['name']);
                    $results[] = ['section', $sec->Add($fields), $sec->LAST_ERROR];
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            var_export($e);
        }
    }
    var_export($results);
} else {
    echo 'did you forget something?';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
