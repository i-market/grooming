<?php

namespace App;

use Core\Env;
use Core\View as v;
use Core\Strings;

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
    const PRODUCT_CATEGORIES = 'product_categories';
    const TAXI_ADVANTAGES = 'taxi_advantages';
}

class Util {
    static function normalizePhoneNumber($string) {
        return Strings::replaceAll($string, '/[^\+\d]/', '');
    }
}