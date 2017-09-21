<?
$arUrlRewrite = array(
    array(
        "CONDITION" => "#^/grooming/([a-zA-Z_-]+)/([a-zA-Z_-]+)/#",
        "RULE" => "SECTION_CODE=\$1&IBLOCK_CODE=\$2",
        "ID" => "",
        "PATH" => "/grooming/services.php",
    ),
    array(
        "CONDITION" => "#^/grooming/without_appointment/#",
        "RULE" => "SECTION_CODE=&IBLOCK_CODE=without_appointment",
        "ID" => "",
        "PATH" => "/grooming/services.php",
    ),
    array(
        "CONDITION" => "#^/grooming/#",
        "RULE" => "",
        "ID" => "bitrix:catalog",
        "PATH" => "/grooming/index.php",
    ),
    array(
		"CONDITION" => "#^/api/.*#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/api/dispatch.php",
	),
);

?>