<?php

use App\Iblock;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\SectionElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;
use Core\Nullable as nil;
use Core\Underscore as _;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("migration");

$tasks = nil::get(nil::map($_REQUEST['tasks'], function($s) {
    return explode(',', $s);
}), []);
if ($USER->IsAdmin() && !_::isEmpty($tasks)) {
    $results = [];
    if (in_array('migrate', $tasks)) {
        \Bitrix\Main\Loader::includeModule('iblock');
        $propFields = function($iblockId, $name, $code) {
            return [
                'NAME' => $name,
                'CODE' => $code,
                'ACTIVE' => 'Y',
                'IS_REQUIRED' => 'N',
                'SORT' => '500',
                'PROPERTY_TYPE' => 'S',
                'MULTIPLE' => 'N',
                'FILTRABLE' => 'Y',
                'IBLOCK_ID' => $iblockId,
            ];
        };
        $iblocks = IblockTable::getList([
            'filter' => ['IBLOCK_TYPE_ID' => Iblock::SERVICES_TYPE]
        ])->fetchAll();
        $iblocks = _::map($iblocks, function($iblock) {
            return _::set($iblock, 'PROPERTIES', PropertyTable::getList(['filter' => ['IBLOCK_ID' => $iblock['ID']]])->fetchAll());
        });
        $allProps = array_reduce(_::pluck($iblocks, 'PROPERTIES'), 'array_merge', []);
        $getCode = function($prop) { return $prop['CODE']; };
        $mergedPropSpecs = _::map(_::uniqBy($allProps, $getCode), function($prop) use ($iblockId) {
            return _::pick($prop, ['NAME', 'CODE']);
        });
        $mergedPropSpecs = _::prepend($mergedPropSpecs, ['NAME' => 'Название услуги', 'CODE' => 'NAME']);
        $data = [];
        foreach ($iblocks as $iblock) {
            $sections = SectionTable::getList(['filter' => ['IBLOCK_ID' => $iblock['ID']]])->fetchAll();
            $el = new CIBlockElement();
            $data[$iblock['ID']] = [
                'elements' => Core\Iblock::collectElements($el->GetList([], ['IBLOCK_ID' => $iblock['ID']])),
                'sections' => _::keyBy('ID', $sections),
                'section_elements' => SectionElementTable::getList(['filter' => ['IBLOCK_SECTION_ID' => _::pluck($sections, 'ID')]])->fetchAll(),
            ];
        }

        // iblock-associated images
        $el = new CIBlockElement();
        $codeFilter = array_merge(['LOGIC' => 'OR'], _::map($iblocks, function($iblock) {
            return ['CODE' => $iblock['CODE']];
        }));
        // only dog images are present now
        $dogImageIdByCode = _::reduce(ElementTable::getList(['filter' => $codeFilter])->fetchAll(), function($acc, $el) {
            return _::set($acc, $el['CODE'], $el['DETAIL_PICTURE']);
        }, []);

        $conn = Application::getConnection();
        $conn->startTransaction();
        try {
            // create common iblock
            $iblockSpec = [
                'NAME' => 'Услуги',
                'CODE' => 'services',
                'TYPE' => Iblock::SERVICES_TYPE,
            ];
            $cIBlock = new CIBlock();
            $dbIBlock = $cIBlock->GetList(
                [],
                ['CODE' => $iblockSpec['CODE']]
            );
            if ($dbIBlock->Fetch()) {
                throw new Exception("iblock with code {$iblockSpec['CODE']} already exists");
            }
            $iblockId = $cIBlock->Add([
                'NAME' => $iblockSpec['NAME'],
                'CODE' => $iblockSpec['CODE'],
                'IBLOCK_TYPE_ID' => $iblockSpec['TYPE'],
                'VERSION' => 1,
                'SITE_ID' => ['s1'],
                'GROUP_ID' => ['2' => 'R'],
            ]);
            if (false === $iblockId) {
                throw new Exception($cIBlock->LAST_ERROR);
            }
            foreach ($mergedPropSpecs as $spec) {
                $prop = new CIBlockProperty();
                $result = $prop->Add($propFields($iblockId, $spec['NAME'], $spec['CODE']));
                assert($result, $prop->LAST_ERROR);
            }

            // top level sections
            $results[] = 'top level sections';
            $topLevelSpecs = [
                [
                    'code' => 'dogs',
                    'name' => 'Услуги для собак'
                ],
                [
                    'code' => 'cats',
                    'name' => 'Услуги для кошек'
                ],
                [
                    'code' => 'default',
                    'name' => 'Другие услуги'
                ]
            ];
            $topLevelSectionIds = _::reduce($topLevelSpecs, function($acc, $spec) use ($iblockId, &$results) {
                $section = new CIBlockSection();
                $fields = [
                    'IBLOCK_ID' => $iblockId,
                    'NAME' => $spec['name'],
                    'CODE' => $spec['code'],
                ];
                $sectionId = $section->Add($fields);
                if ($sectionId === false) {
                    throw new Exception($section->LAST_ERROR);
                }
                $results[] = 'added top level section: '.json_encode([$sectionId, $fields], JSON_UNESCAPED_UNICODE);
                return _::set($acc, $spec['code'], $sectionId);
            }, []);

            $results[] = _::map($iblocks, function($iblock) use ($topLevelSectionIds, $data, $topLevelSpecs, $dogImageIdByCode, $iblockId, &$results) {
                // convert iblocks into sections
                // code path → section id
                // TODO use stateRef var
                $serviceSectionsRef = [];
                $serviceSection = function($topLevelCode) use (&$serviceSectionsRef, $topLevelSectionIds, $iblock, $dogImageIdByCode, $iblockId, &$results) {
                    if (isset($serviceSectionsRef[$topLevelCode])) {
                        return $serviceSectionsRef[$topLevelCode];
                    }
                    $section = new CIBlockSection();
                    $fields = [
                        'IBLOCK_ID' => $iblockId,
                        'NAME' => $iblock['NAME'],
                        'CODE' => $iblock['CODE'],
                        'IBLOCK_SECTION_ID' => $topLevelSectionIds[$topLevelCode],
                        'PICTURE' => nil::map(_::get($dogImageIdByCode, $iblock['CODE']), [CFile::class, 'CopyFile'])
                    ];
                    $sectionId = $section->Add($fields);
                    if ($sectionId === false) {
                        throw new Exception($section->LAST_ERROR);
                    }
                    $serviceSectionsRef[$topLevelCode] = $sectionId;
                    $results[] = 'added service section: '.json_encode([$sectionId, $fields], JSON_UNESCAPED_UNICODE);
                    return $sectionId;
                };
                $relsByElement = _::groupBy($data[$iblock['ID']]['section_elements'], 'IBLOCK_ELEMENT_ID');
                // previous id → new id
                $stateRef = [];
                // lazily add sections, including parents, return new section id
                $newSectionId = function($localRootId, $prevId) use (&$stateRef, &$newSectionId, $iblock, $data, $topLevelSpecs, $iblockId, &$results) {
                    if ($prevId === null) {
                        return null;
                    }
                    if (isset($stateRef[$prevId])) {
                        return $stateRef[$prevId];
                    }
                    $prevSection = $data[$iblock['ID']]['sections'][$prevId];
                    assert($prevSection);
                    $section = new CIBlockSection();
                    $fields = _::pick($prevSection, ['NAME', 'CODE', 'IBLOCK_SECTION_ID', 'DESCRIPTION', 'PICTURE']);
                    $fields['IBLOCK_SECTION_ID'] = _::get($fields, 'IBLOCK_SECTION_ID') === null
                        ? $localRootId
                        : $newSectionId($localRootId, $fields['IBLOCK_SECTION_ID']);
                    $fields = _::update($fields, 'PICTURE', function($fileId) {
                        $ret = CFile::CopyFile($fileId);
                        if (!is_numeric($ret)) {
                            throw new Exception("couldn't copy the file: {$ret}");
                        }
                        return $ret;
                    });
                    $fields['IBLOCK_ID'] = $iblockId;
                    $sectionId = $section->Add($fields);
                    assert(is_numeric($sectionId), $section->LAST_ERROR);
                    $results[] = 'added (restored) section: '.json_encode([$sectionId, $fields], JSON_UNESCAPED_UNICODE);
                    $stateRef[$prevId] = $sectionId;
                    return $sectionId;
                };
                $registerSectionMapping = function($prevId, $newId) use (&$stateRef) {
                    $stateRef[$prevId] = $newId;
                };
                $elements = $data[$iblock['ID']]['elements'];
                assert($elements || $iblock['CODE'] === 'other_services');
                // add elements
                $elementIds = _::map($elements, function($element) use ($relsByElement, $newSectionId, $topLevelSpecs, $data, $iblock, $serviceSection, $iblockId, $registerSectionMapping, &$results) {
                    $el = new CIBlockElement();
                    $propValues = _::reduce($element['PROPERTIES'], function($acc, $prop) {
                        return _::set($acc, $prop['CODE'], $prop['~VALUE']);
                    }, []);
                    $propValues['NAME'] = $element['~NAME'];
                    $fields = array_merge(_::pick($element, ['CODE', 'SORT']), [
                        'NAME' => $element['~NAME'],
                        'IBLOCK_ID' => $iblockId,
                        'PROPERTY_VALUES' => $propValues
                    ]);
                    if ($iblock['CODE'] === 'fancy_haircut') {
                        $propValues['BREED'] = trim($propValues['BREED']) !== '' ? $propValues['BREED'] : $element['~NAME'];
                        $propValues['NAME'] = '';
                    } elseif ($iblock['CODE'] === 'buzzcut') {
                        $propValues['BREED'] = $element['~NAME'];
                        $propValues['NAME'] = '';
                    } elseif ($iblock['CODE'] === 'haircut') {
                        $propValues['BREED'] = '';
                    }
                    $elementId = $el->Add($fields);
                    assert(is_numeric($elementId), $el->LAST_ERROR);
                    $results[] = 'added element: '.json_encode([$elementId, $fields], JSON_UNESCAPED_UNICODE);

                    // update section relationships

                    $allPrevSectionIds = _::pluck($relsByElement[$element['ID']], 'IBLOCK_SECTION_ID');

                    $prevTopLevelIdMaybe = _::find($allPrevSectionIds, function($sectionId) use ($topLevelSpecs, $data, $iblock, $serviceSection, $registerSectionMapping) {
                        $section = $data[$iblock['ID']]['sections'][$sectionId];
                        $isRoot = _::get($section, 'IBLOCK_SECTION_ID') === null;
                        return $isRoot && in_array($section['CODE'], _::pluck($topLevelSpecs, 'code'));
                    });
                    if ($prevTopLevelIdMaybe !== null) {
                        // replace root section with our own
                        $prevTopLevelCode = _::get($data, join('.', [$iblock['ID'], 'sections', $prevTopLevelIdMaybe, 'CODE']));
                        $newRootId = $serviceSection($prevTopLevelCode);
                        assert($newRootId);
                        $registerSectionMapping($prevTopLevelIdMaybe, $newRootId);
                        $prevSectionIds = _::without($allPrevSectionIds, $prevTopLevelIdMaybe);
                        $sectionIds = _::append(_::map($prevSectionIds, _::partial($newSectionId, $newRootId)), $newRootId);
                    } else {
                        $prevSectionIds = $allPrevSectionIds;
                        $sectionIds = _::map($prevSectionIds, _::partial($newSectionId, null));
                    }

                    // SectionElementTable::add doesn't work for some reason
                    $result = $el->SetElementSection($elementId, $sectionIds);
                    $results[] = 'added rels: '.json_encode([$elementId, $sectionIds], JSON_UNESCAPED_UNICODE);
                    assert($result);
                    return $elementId;
                });
                return $elementIds;
            });

            // TODO clean up empty sections?

            // TODO tmp
//            $conn->rollbackTransaction();
            $conn->commitTransaction();
        } catch (Exception $e) {
            $conn->rollbackTransaction();
            throw $e;
        }
    }
    echo '<pre>';
    var_export($results);
    echo '</pre>';
} else {
    echo 'something is missing';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
