<?php

namespace App;

use Bitrix\Main\Config\Configuration;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Mail\Event;
use Core\Env;
use Core\View as v;
use Core\Strings;
use Core\Underscore as _;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as val;

class App {
    const SITE_ID = 's1';

    static function useBitrixAsset() {
        // use bitrix asset pipeline for non-dev environments
        return \Core\App::env() !== Env::DEV;
    }

    static function layoutContext($options = []) {
        $scripts = self::useBitrixAsset() ? [] : self::assets()['scripts'];
        $ret = [
            'scripts' => $scripts,
            'header' => [
                'phone_fragment' => v::renderIncludedArea('header_phone.php', ['PARAMS' => ['HIDE_ICONS' => 'Y']]),
                'menu' => Layout::renderHeaderMenu()
            ],
            'footer' => [
                'menu' => Layout::renderFooterMenu(),
                'about_us' => v::twig()->render(v::partial('footer/about_us.twig'), [
                    'heading' => v::renderIncludedArea('footer/about_us/heading.php'),
                    'body' => v::renderIncludedArea('footer/about_us/body.php')
                ]),
                'contact' => v::renderIncludedArea('footer/contact.php', ['PARAMS' => ['HIDE_ICONS' => 'Y']]),
                'copyright' => v::renderIncludedArea('footer/copyright.php')
            ],
            'modals' => [
                // callback request
                're_call' => [
                    'uri' => Api::uri(Api::CALLBACK_PATH)
                ]
            ]
        ];
        if (isset($options['hero_banner'])) {
            $ret['hero_banner'] = HeroBanner::render($options['hero_banner']);
        }
        return $ret;
    }

    static function assets() {
        $styles = array_map(function($path) {
            return v::asset($path);
        }, [
            'css/lib/normalize.min.css',
            'css/lib/jquery.fancybox.css',
            'css/lib/slick.css',
            'css/main.css'
        ]);
        $scripts = array_merge(
            [
                '//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js',
                'https://use.fontawesome.com/d5e5cdfb8c.js'
            ],
            array_map(function($path) {
                return v::asset($path);
            }, [
                'js/vendor/slick.min.js',
                'js/vendor/wow.min.js',
                'js/vendor/jquery.fancybox.pack.js',
                'js/script.js'
            ])
        );
        return [
            'styles' => $styles,
            'scripts' => $scripts
        ];
    }

    static function sendMailEvent($eventName, $fields) {
        // TODO save in case mail delivery fails
        $event = [
            'EVENT_NAME' => $eventName,
            'LID' => self::SITE_ID,
            'C_FIELDS' => $fields
        ];
        return Event::sendImmediate($event);
    }

    static function emailTo() {
        $app = Configuration::getValue('app');
        $ret = _::get($app, 'email_to', Option::get('main', 'email_from'));
        if (Strings::isEmpty($ret)) {
            trigger_error("can't find default email-to address", E_USER_WARNING);
        }
        return $ret;
    }

    static function requestCallback($data) {
        $fields = [
            'name' => [
                'label' => 'ФИО',
                'validator' => val::stringType()->notEmpty()
                    ->setTemplate('Пожалуйста, заполните поле «ФИО».')
            ],
            'phone' => [
                'label' => 'Телефон',
                'validator' => val::stringType()->notEmpty()
                    ->setTemplate('Пожалуйста, заполните поле «Телефон».')
            ]
        ];
        $errors = _::clean(_::mapValues($fields, function($field, $key) use ($data) {
            try {
                $field['validator']->assert($data[$key]);
                return null;
            } catch(NestedValidationException $exception) {
                return $exception->getMainMessage();
            }
        }));
        $isValid = _::isEmpty($errors);
        if ($isValid) {
            self::sendMailEvent(MailEvent::CALLBACK_REQUEST, [
                'EMAIL_TO' => self::emailTo(),
                'NAME' => $data['name'],
                'PHONE' => $data['phone'],
                'MESSAGE' => $data['message']
            ]);
        }
        return [
            'type' => $isValid ? 'success' : 'error',
            'errors' => ['fields' => $errors]
        ];
    }
}

class MailEvent {
    const CALLBACK_REQUEST = 'CALLBACK_REQUEST';
}

class PageProperty {
    const LAYOUT = 'layout';
}

class Iblock {
    const CONTENT_TYPE = 'content';
    const SERVICE = 'service';
    const WHY_US = 'why_us';
    const PROMOTIONS = 'promotions';
    const IMAGES = 'images';
    const BANNERS = 'banners';
    const HERO_BANNERS = 'hero_banners';
    const PRODUCT_CATEGORIES = 'product_categories';
    const TAXI_ADVANTAGES = 'taxi_advantages';
    const TAXI_PRICING = 'taxi_pricing';
    const GROOMING_SERVICE = 'grooming_service';
    const BODY_PARTS = 'body_parts';
    const HOTEL_SERVICES = 'hotel_services';
}

class Util {
    static function normalizePhoneNumber($string) {
        return Strings::replaceAll($string, '/[^\+\d]/', '');
    }
}