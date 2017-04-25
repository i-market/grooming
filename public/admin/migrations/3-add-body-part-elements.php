<?php

use App\Iblock;
use Bex\Tools\Iblock\IblockTools;
use Core\Nullable as nil;
use Core\Underscore as _;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("migration");

$tasks = nil::get(nil::map($_REQUEST['tasks'], function($s) {
    return explode(',', $s);
}), []);
if ($USER->IsAdmin() && !_::isEmpty($tasks)) {
    $results = [];
    if (in_array('default', $tasks)) {
        $previewText = 'Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем только качественную и прошедшую сертификацию косметику. Красота и здоровье Вашего питомца – основные принципы нашей работы, поэтому мы выбираем.';
        foreach (range(1, 8) as $n) {
            $el = new CIBlockElement();
            $result = $el->Add([
                'IBLOCK_ID' => IblockTools::find(Iblock::CONTENT_TYPE, Iblock::BODY_PARTS)->id(),
                'NAME' => 'Часть тела '.$n,
                'PREVIEW_TEXT' => $previewText,
                'PROPERTY_VALUES' => [
                    'MARKER_ID' => 'plus'.$n
                ]
            ]);
            $results[] = [$result, $el->LAST_ERROR];
        }
    }
    echo '<pre>';
    var_export($results);
    echo '</pre>';
} else {
    echo 'did you forget something?';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
