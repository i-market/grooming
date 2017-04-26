<?php

use App\Iblock;
use Bex\Tools\Iblock\IblockTools;
use Bitrix\Iblock\SectionElementTable;
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
                'only_section' => 'dogs',
                'file' => 'Купание (собаки).tsv'
            ],
            [
                'iblock_code' => 'other_services',
                'only_section' => 'cats',
                'file' => 'Кошки.tsv'
            ],
            [
                'iblock_code' => 'fancy_haircut',
                'only_section' => 'dogs',
                'file' => 'Модельная стрижка.tsv'
            ],
            [
                'iblock_code' => 'haircut',
                'only_section' => 'dogs',
                'tab_section_name' => 'Купание + гигиеническая стрижка',
                'file' => 'Стрижка гигиеническая.tsv'
            ],
            [
                'iblock_code' => 'haircut',
                'only_section' => 'dogs',
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
            $sectionIds = array_reduce(['dogs', 'cats'], function($acc, $code) use ($iblockId) {
                $id = SectionTable::query()
                    ->setSelect(['*'])
                    ->setFilter([
                        'IBLOCK_ID' => $iblockId,
                        'CODE' => $code
                    ])->exec()->fetch()['ID'];
                return _::set($acc, $code, $id);
            }, []);
            $onlySectionId = null;
            if (isset($fixture['only_section'])) {
                $onlySectionId = SectionTable::query()
                    ->setSelect(['*'])
                    ->setFilter([
                        'IBLOCK_ID' => $iblockId,
                        'CODE' => $fixture['only_section']
                    ])->exec()->fetch()['ID'];
            }
            $presetTabSectionId = null;
            if (isset($fixture['tab_section_name'])) {
                $sec = new CIBlockSection();
                $fields = [
                    'IBLOCK_ID' => $iblockId,
                    'NAME' => $fixture['tab_section_name'],
                ];
                $presetTabSectionId = $sec->Add($fields);
            }
            $defaultSection = SectionTable::query()
                ->setSelect(['*'])
                ->setFilter([
                    'IBLOCK_ID' => $iblockId,
                    'CODE' => 'default'
                ])->exec()->fetch();
            foreach ($rowMaps as $row) {
                if ($row['type'] === 'section') {
                    $sec = new CIBlockSection();
                    $fields = [
                        'IBLOCK_ID' => $iblockId,
                        'NAME' => $row['NAME']
                    ];
                    if ($presetTabSectionId !== null) {
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
                    $elementId = $el->Add($fields);
                    $results[] = ['add element', $elementId, $el->LAST_ERROR];
                    if ($onlySectionId !== null) {
                        $results[] = SectionElementTable::add([
                            'IBLOCK_SECTION_ID' => $onlySectionId,
                            'IBLOCK_ELEMENT_ID' => $elementId
                        ]);
                    } else {
                        foreach ($sectionIds as $sectionId) {
                            $results[] = SectionElementTable::add([
                                'IBLOCK_SECTION_ID' => $sectionId,
                                'IBLOCK_ELEMENT_ID' => $elementId
                            ]);
                        }
                    }
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
