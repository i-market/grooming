<?php

$arComponentParameters = [
    'PARAMETERS' => [
        'ADDRESS' => [
            'NAME' => 'Адрес',
            'TYPE' => 'STRING',
            'DEFAULT' => ''
        ],
        'LATLNG' => [
            'NAME' => 'Географические координаты (широта, долгота)',
            'TYPE' => 'STRING',
            'DEFAULT' => ''
        ],
        'EMAILS' => [
            'NAME' => 'Email-адреса',
            'TYPE' => 'LIST',
            'MULTIPLE' => 'Y',
            'ADDITIONAL_VALUES' => 'Y',
            'DEFAULT' => ''
        ],
        'PHONES' => [
            'NAME' => 'Телефоны',
            'TYPE' => 'LIST',
            'MULTIPLE' => 'Y',
            'ADDITIONAL_VALUES' => 'Y',
            'DEFAULT' => ''
        ],
        'URLS' => [
            'NAME' => 'URL-адреса',
            'TYPE' => 'LIST',
            'MULTIPLE' => 'Y',
            'ADDITIONAL_VALUES' => 'Y',
            'DEFAULT' => ''
        ],
        'HOURS_OF_OPERATION' => [
            'NAME' => 'Время работы',
            'TYPE' => 'STRING',
            'DEFAULT' => ''
        ]
    ]
];
