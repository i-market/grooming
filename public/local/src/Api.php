<?php

namespace App;

use Klein\Klein;

class Api {
    const CALLBACK_PATH = '/callback';

    static function uri($path) {
        return '/api'.$path;
    }

    static function router() {
        $router = new Klein();
        $router->with('/api', function () use ($router) {
            $router->respond('POST', self::CALLBACK_PATH, function($request, $response) {
                $data = $request->params(['name', 'phone', 'message']);
                return $response->json((object) App::requestCallback($data));
            });
        });
        return $router;
    }
}