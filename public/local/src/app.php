<?php

namespace App;

use Core\Env;
use Core\View as v;
use Core\Strings;
use Core\View;

class App {
    const SITE_ID = 's1';

    static function useBitrixAsset() {
        // use bitrix asset pipeline for non-dev environments
        return \Core\App::env() !== Env::DEV;
    }

    static function layoutContext() {
        $scripts = self::useBitrixAsset() ? [] : self::assets()['scripts'];
        return [
            'scripts' => $scripts,
            'header' => [
                'phone_fragment' => View::renderIncludedArea('header_phone.php', ['PARAMS' => ['HIDE_ICONS' => 'Y']])
            ],
            'copyright_year' => date('Y')
        ];
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
}

class PageProperty {
    const LAYOUT = 'layout';
}

class Iblock {
    const CONTENT_TYPE = 'content';
    const SERVICE = 'service';
    const WHY_US = 'why_us';
    const PROMOTIONS = 'promotions';
    const GALLERY = 'gallery';
    const BANNERS = 'banners';
    const HERO_BANNERS = 'hero_banners';
}

class Util {
    static function normalizePhoneNumber($string) {
        return Strings::replaceAll($string, '/[^\+\d]/', '');
    }
}