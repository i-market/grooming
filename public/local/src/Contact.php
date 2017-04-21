<?php

namespace App;

class Contact {
    static function layoutContext() {
        return array_merge(App::layoutContext(), [
            'hide_breadcrumbs' => true
        ]);
    }

    static function parseLatlng($string) {
        $matchesRef = [];
        return preg_match('/(\-?\d+(?:\.\d+)?),\s*(\-?\d+(?:\.\d+)?)/', $string, $matchesRef)
            ? ['lat' => $matchesRef[1], 'lng' => $matchesRef[2]]
            : null;
    }
}