<?php

namespace Core;

use Bitrix\Main\Config\Configuration;
use CBitrixComponentTemplate;
use CFile;
use CIBlock;
use Core\Underscore as _;
use Core\View as v;
use Core\Nullable as nil;
use Maximaster\Tools\Twig\TemplateEngine;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;
use Underscore\Methods\ArraysMethods;
use Underscore\Methods\StringsMethods;

class Underscore extends ArraysMethods {
    /** @deprecated use `map` */
    static function mapValues($array, $f) {
        $ret = array();
        foreach ($array as $k => $v) {
            $ret[$k] = is_string($f) ? self::get($v, $f) : $f($v, $k);
        }
        return $ret;
    }


    static function map($array, $f) {
        $ret = [];
        foreach ($array as $k => $v) {
            $ret[$k] = is_callable($f) ? $f($v, $k) : self::get($v, $f);
        }
        return $ret;
    }

    static function mapKeys($array, $f) {
        $ret = array();
        foreach ($array as $k => $v) {
            $result = is_string($f) ? self::get($v, $f) : $f($v, $k);
            $ret[$result] = $v;
        }
        return $ret;
    }

    static function flatMap($array, $f) {
        $ret = [];
        foreach ($array as $k => $v) {
            $xs = is_callable($f) ? $f($v, $k) : self::get($v, $f);
            foreach ($xs as $x) {
                $ret[] = $x;
            }
        }
        return $ret;
    }

    static function pick($array, $keys) {
        return array_filter($array, function ($key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    // TODO refactor: optimize?
    static function reduce($array, $f, $initial) {
        return array_reduce(array_keys($array), function($ret, $k) use ($array, $f) {
            return $f($ret, $array[$k], $k);
        }, $initial);
    }

    static function filter($array, $pred = null) {
        // restore indices
        return array_values(array_filter($array, $pred));
    }
    
    static function drop($array, $n) {
        return array_slice($array, $n);
    }

    static function take($array, $n) {
        return array_slice($array, 0, $n);
    }

    static function update($array, $key, callable $f) {
        return !self::has($array, $key)
            ? $array
            : self::set($array, $key, $f(self::get($array, $key)));
    }

    static function isEmpty($x) {
        return is_array($x) && count($x) === 0;
    }
    
    static function groupBy($array, $f) {
        $ret = array();
        foreach ($array as $x) {
            $key = is_string($f) ? self::get($x, $f) : $f($x);
            $ret[$key][] = $x;
        }
        return $ret;
    }

    static function uniqBy($array, callable $f) {
        $seenRef = [];
        $ret = [];
        foreach ($array as $k => $v) {
            $computed = $f($v, $k);
            if (!self::contains($seenRef, $computed)) {
                $seenRef[] = $computed;
                // preserve keys? not sure
                $ret[] = $v;
            }
        }
        return $ret;
    }

    // TODO function $by support
    static function keyBy($by, $array) {
        assert(is_string($by));
        $ret = array();
        foreach ($array as $x) {
            $ret[$x[$by]] = $x;
        }
        return $ret;
    }

    /**
     * @return array Returns an array of [(take n) (drop n)]
     */
    static function splitAt($array, $n) {
        return array(self::take($array, $n), self::drop($array, $n));
    }

    static function identity($x) {
        return $x;
    }

    static function constantly($x) {
        return function() use ($x) {
            return $x;
        };
    }

    static function partial(callable $f, ...$args) {
        return function (...$rest) use ($f, $args) {
            return $f(...array_merge($args, $rest));
        };
    }

    static function partialRight(callable $f, ...$args) {
        return function (...$rest) use ($f, $args) {
            return $f(...array_merge($rest, $args));
        };
    }
}

class Nullable {
    static public function get($nullable, $default) {
        return $nullable === null ? $default : $nullable;
    }

    static public function map($nullable, callable $f) {
        return $nullable !== null ? $f($nullable) : $nullable;
    }
}

class Strings extends StringsMethods {
    static function isEmpty($str) {
        return $str === null || trim($str) === '';
    }

    static function ifEmpty($str, $value) {
        return self::isEmpty($str) ? $value : $str;
    }

    static function contains($s, $subString) {
        return strpos($s, $subString) !== false;
    }

    static function replaceAll($s, $pattern, $replacement) {
        while(preg_match($pattern, $s)) {
            $s = preg_replace($pattern, $replacement, $s);
        }
        return $s;
    }
}

class Env {
    const DEV = "dev";
    const PROD = "prod";
}

class App {
    static function env() {
        $app = Nullable::get(Configuration::getValue('app'), array());
        return _::get($app, 'env', Env::PROD);
    }
}

class View {
    private static $assetManifest = null;
    private static $footer = null;

    static function asset($path) {
        $build = SITE_TEMPLATE_PATH.'/build';
        if (App::env() === Env::DEV) {
            return $build.'/assets/'.$path;
        } else {
            if (self::$assetManifest === null) {
                $manifestFile = $_SERVER['DOCUMENT_ROOT'].$build.'/rev/rev-manifest.json';
                self::$assetManifest = json_decode(file_get_contents($manifestFile), true);
            }
            if (isset(self::$assetManifest[$path])) {
                return $build.'/rev/'.self::$assetManifest[$path];
            } else {
                return $build.'/assets/'.$path;
            }
        }
    }

    static function showForProperty($propName, $f, $defaultVal = null) {
        global $APPLICATION;
        $APPLICATION->AddBufferContent(function() use ($propName, $defaultVal, $f, &$APPLICATION) {
            $propVal = $APPLICATION->GetProperty($propName, $defaultVal);
            ob_start();
            if ($propVal !== false) {
                $f($propVal);
            }
            return ob_get_clean();
        });
    }

    static function showLayoutHeader($pageProperty, $defaultLayout, $defaultContextFn) {
        v::showForProperty($pageProperty, function($layout) use ($defaultContextFn) {
            $path = is_array($layout) ? $layout[0] : $layout;
            $propCtxMaybe = is_array($layout) ? $layout[1] : null;
            if (is_callable($propCtxMaybe)) {
                $propCtxMaybe = $propCtxMaybe();
            } else if ($propCtxMaybe !== null) {
                // non-callables will evaluate in admin ui without the appropriate context and cause weird things to happen
                trigger_error('non-callable contexts are deprecated', E_USER_WARNING);
            }
            $twig = TemplateEngine::getInstance()->getEngine();
            $placeholder = '<page-placeholder/>';
            $layoutContext = nil::get($propCtxMaybe, $defaultContextFn());
            $ctx = array_merge(['page' => $placeholder], $layoutContext);
            $html = $twig->render(SITE_TEMPLATE_PATH.'/layouts/'.$path, $ctx);
            list($header, $footer) = explode($placeholder, $html);
            self::$footer = $footer;
            echo $header;
        }, $defaultLayout);
    }

    static function showLayoutFooter() {
        global $APPLICATION;
        $APPLICATION->AddBufferContent(function() {
            assert(self::$footer !== null);
            return self::$footer;
        });
    }

    static function resize($imageFileArray, $width, $height) {
        $dimensions = ['width' => $width, 'height' => $height];
        return CFile::ResizeImageGet($imageFileArray, $dimensions)['src'];
    }

    static function twig() {
        return TemplateEngine::getInstance()->getEngine();
    }

    static function initTwig() {
        $twig = self::twig();
        $twig->addExtension(new BreakpointExtension());
        $twig->addFunction(new Twig_SimpleFunction('asset', 'Core\View::asset'));
        $twig->addFunction(new Twig_SimpleFunction('partial', 'Core\View::partial'));
        $twig->addFunction(new Twig_SimpleFunction('path', 'Core\View::path'));
        $twig->addFunction(new Twig_SimpleFunction('layout', 'Core\View::layout'));
        $twig->addFunction(new Twig_SimpleFunction('resize', 'Core\View::resize'));
        $twig->addFunction(new Twig_SimpleFunction('add_editing_actions', 'Core\NewsListLike::addEditingActions'));

    }

    static function partial($path) {
        return SITE_TEMPLATE_PATH.'/partials/'.$path;
    }

    static function path($path) {
        // TODO ad-hoc
        if ($path === '/') return SITE_DIR;
        return SITE_DIR.$path.'/';
    }

    static function includedArea($path) {
        return SITE_DIR.'include/'.$path;
    }

    static function layout($path) {
        return SITE_TEMPLATE_PATH.'/layouts/'.$path;
    }

    static function renderIncludedArea($path, $options = array()) {
        global $APPLICATION;
        $opts = array_merge(array(
            'TEMPLATE' => '.default',
            'PARAMS' => array()
        ), $options);
        ob_start();
        $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            $opts['TEMPLATE'],
            Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => v::includedArea($path)
            ),
            null,
            $opts['PARAMS']
        );
        return ob_get_clean();
    }

    static function assocResized($items, $key, $dimensions) {
        $assoc = function($item) use ($key, $dimensions) {
            $resized = CFile::ResizeImageGet($item[$key], $dimensions);
            return _::set($item, $key.'.RESIZED', $resized);
        };
        if (_::has($items, $key)) {
            return $assoc($items);
        } else {
            return array_map($assoc, $items);
        }
    }
}

class NewsListLike {
    private static function elementEditingLinks($element) {
        assert(isset($element['IBLOCK_ID']));
        assert(isset($element['ID']));
        // from news.list
        $arButtons = \CIBlock::GetPanelButtons(
            $element["IBLOCK_ID"],
            $element["ID"],
            0,
            array("SECTION_BUTTONS"=>false, "SESSID"=>false)
        );
        return [
            "EDIT_LINK" => $arButtons["edit"]["edit_element"]["ACTION_URL"],
            "DELETE_LINK" => $arButtons["edit"]["delete_element"]["ACTION_URL"]
        ];
    }

    private static function sectionEditingLinks($section) {
        assert(isset($section['IBLOCK_ID']));
        assert(isset($section['ID']));
        // from catalog.section.list
        $arButtons = \CIBlock::GetPanelButtons(
            $section["IBLOCK_ID"],
            0,
            $section["ID"],
            array("SESSID"=>false, "CATALOG"=>true)
        );
        return [
            "EDIT_LINK" => $arButtons["edit"]["edit_section"]["ACTION_URL"],
            "DELETE_LINK" => $arButtons["edit"]["delete_section"]["ACTION_URL"]
        ];
    }

    /**
     * @param array $el
     * @param CBitrixComponentTemplate $template
     * @return string dom element id
     */
    static function addEditingActions($el, $template, $type = 'element') {
        $isSection = $type === 'section' || isset($el['DEPTH_LEVEL']);
        if (!_::isEmpty(array_diff(['EDIT_LINK', 'DELETE_LINK'] , array_keys($el)))) {
            $links = $isSection ? self::sectionEditingLinks($el) : self::elementEditingLinks($el);
            $el = array_merge($el, $links);
        }
        $template->AddEditAction($el['ID'], $el['EDIT_LINK'],
            CIBlock::GetArrayByID($el['IBLOCK_ID'], $isSection ? 'SECTION_EDIT' : 'ELEMENT_EDIT'));
        $template->AddDeleteAction($el['ID'], $el['DELETE_LINK'],
            CIBlock::GetArrayByID($el['IBLOCK_ID'], $isSection ? 'SECTION_DELETE' : 'ELEMENT_DELETE'),
            ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
        return $template->GetEditAreaId($el['ID']);
    }
}

// https://github.com/ajgarlag/AjglBreakpointTwigExtension/blob/0dfa4f0ae3bbeb6c8036e3e6d6c204c43b090155/src/BreakpointExtension.php
class BreakpointExtension extends Twig_Extension {
    public function getName() {
        return 'breakpoint';
    }

    public function getFunctions() {
        return [
            new Twig_SimpleFunction('breakpoint', [$this, 'setBreakpoint'], ['needs_environment' => true, 'needs_context' => true]),
        ];
    }

    /**
     * If XDebug is detected, makes the debugger break.
     *
     * @param Twig_Environment $environment the environment instance
     * @param mixed            $context     variables from the Twig template
     */
    public function setBreakpoint(Twig_Environment $environment, $context) {
        if (function_exists('xdebug_break')) {
            $arguments = array_slice(func_get_args(), 2);
            xdebug_break();
        }
    }
}
