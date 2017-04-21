<?
$arUrlRewrite = array(
    array(
        "CONDITION" => "#^/grooming/([a-zA-Z_-]+)/([a-zA-Z_-]+)/#",
        "RULE" => "SECTION_CODE=\$1&IBLOCK_CODE=\$2",
        "ID" => "",
        "PATH" => "/grooming/services.php",
    ),
    array(
		"CONDITION" => "#^/api/.*#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/api/dispatch.php",
	),
);

?>