<?
use App\App;
use App\PageProperty;

include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus('404 Not Found');
@define('ERROR_404', 'Y');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404");
$APPLICATION->SetPageProperty(PageProperty::LAYOUT, ['default.twig', function() {
    return array_merge(App::layoutContext(), [
        'hide_breadcrumbs' => true,
        'content_class' => 'error'
    ]);
}]);
?>

<h1 class="h2">Ошибка 404</h1>
<p>Страница не найдена или была удалена. Пожалуйста, проверьте URL-адрес.</p>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
