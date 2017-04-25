<?php

use App\Iblock;
use Bex\Tools\Iblock\IblockTools;
use Bitrix\Iblock\SectionTable;
use Core\Nullable as nil;
use Core\Underscore as _;
use Core\Strings as str;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("migration");

$tasks = nil::get(nil::map($_REQUEST['tasks'], function($s) {
    return explode(',', $s);
}), []);
if ($USER->IsAdmin() && !_::isEmpty($tasks)) {
    $slurpFixture = function($path) {
        return file_get_contents($_SERVER['DOCUMENT_ROOT'].'/local/fixtures/'.$path);
    };
    $parseTsv = function($str) {
        $lines = preg_split('/\r\n|\n|\r/', $str);
        $rows = array_map(function($line) {
            return explode("\t", $line);
        }, $lines);
        return $rows;
    };
    $results = [];
    if (in_array('load', $tasks)) {
        $fixtures = [
            [
                'iblock_code' => 'additional',
                'file' => 'Доп. услуги.tsv'
            ],
            [
                'iblock_code' => 'creative',
                'file' => 'Креативные услуги.tsv'
            ],
            [
                'iblock_code' => 'bathing',
                'root_section' => 'dogs',
                'file' => 'Купание (собаки).tsv'
            ],
            [
                'iblock_code' => 'generic',
                'root_section' => 'cats',
                'file' => 'Кошки.tsv'
            ],
            [
                'iblock_code' => 'fancy_haircut',
                'root_section' => 'dogs',
                'file' => 'Модельная стрижка.tsv'
            ],
            [
                'iblock_code' => 'haircut',
                'root_section' => 'dogs',
                'tab_section_name' => 'Купание + гигиеническая стрижка',
                'file' => 'Стрижка гигиеническая.tsv'
            ],
            [
                'iblock_code' => 'haircut',
                'root_section' => 'dogs',
                'tab_section_name' => 'Стрижка под машинку с купанием',
                'file' => 'Стрижка под машинку.tsv'
            ],
            [
                'iblock_code' => 'without_appointment',
                'file' => 'Услуги без записи.tsv'
            ]
        ];
        $iblockFieldKeys = ['NAME'];
        foreach ($fixtures as $fixture) {
            $allRows = $parseTsv($slurpFixture($fixture['file']));
            $header = _::first($allRows);
            $rows = _::rest($allRows);
            $rowMaps = array_map(function($row) use ($header) {
                // is section if only the first cell is non-empty
                $isSection = !str::isEmpty(_::first($row)) && _::matches(_::rest($row), function($cell) {
                    return str::isEmpty($cell);
                });
                $map = _::reduce($row, function($acc, $cell, $idx) use ($header) {
                    return _::set($acc, $header[$idx], $cell);
                }, []);
                return array_merge([
                    'type' => $isSection ? 'section' : 'element',
                    'NAME' => _::first($row)
                ], $map);
            }, $rows);
            // row group section id
            $inSection = null;
            $iblockId = IblockTools::find(Iblock::SERVICES_TYPE, $fixture['iblock_code'])->id();
            $rootSectionId = null;
            $presetTabSectionId = null;
            if (isset($fixture['root_section'])) {
                $section = SectionTable::query()
                    ->setSelect(['*'])
                    ->setFilter([
                        'IBLOCK_ID' => $iblockId,
                        'CODE' => $fixture['root_section']
                    ])->exec()->fetch();
                $rootSectionId = $section['ID'];
            }
            if (isset($fixture['tab_section_name'])) {
                $sec = new CIBlockSection();
                $fields = [
                    'IBLOCK_ID' => $iblockId,
                    'NAME' => $fixture['tab_section_name'],
                ];
                if ($rootSectionId !== null) {
                    $fields['IBLOCK_SECTION_ID'] = $rootSectionId;
                }
                $presetTabSectionId = $sec->Add($fields);
            }
            $defaultSection = SectionTable::query()
                ->setSelect(['*'])
                ->setFilter([
                    'IBLOCK_ID' => $iblockId,
                    'CODE' => join('_', _::clean([$fixture['root_section'], 'default']))
                ])->exec()->fetch();
            foreach ($rowMaps as $row) {
                if ($row['type'] === 'section') {
                    $sec = new CIBlockSection();
                    $fields = [
                        'IBLOCK_ID' => $iblockId,
                        'NAME' => $row['NAME']
                    ];
                    if ($rootSectionId !== null) {
                       $fields['IBLOCK_SECTION_ID'] = $rootSectionId;
                    } elseif ($presetTabSectionId !== null) {
                        $fields['IBLOCK_SECTION_ID'] = $presetTabSectionId;
                    } else {
                        $fields['IBLOCK_SECTION_ID'] = $defaultSection['ID'];
                    }
                    $sectionId = $sec->Add($fields);
                    $results[] = ['add section', $sectionId, $el->LAST_ERROR];
                    assert(is_int($sectionId));
                    $inSection = $sectionId;
                } elseif ($row['type'] === 'element') {
                    $el = new CIBlockElement();
                    $props = _::remove($row, array_merge($iblockFieldKeys, ['type']));
                    $fields = [
                        'IBLOCK_ID' => $iblockId,
                        'NAME' => $row['NAME'],
                        'PROPERTY_VALUES' => $props
                    ];
                    if ($inSection) {
                        $fields['IBLOCK_SECTION_ID'] = $inSection;
                    } else {
                        if ($presetTabSectionId !== null) {
                            $fields['IBLOCK_SECTION_ID'] = $presetTabSectionId;
                        } else {
                            $fields['IBLOCK_SECTION_ID'] = $defaultSection['ID'];
                        }
                    }
                    $results[] = ['add element', $el->Add($fields), $el->LAST_ERROR];
                }
            }
        }
    }
    echo '<pre>';
    var_export($results);
    echo '</pre>';
} else {
    echo 'did you forget something?';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
