<?php

namespace App;

use Klein\Klein;

class Api {
    static function router() {
        $router = new Klein();
        $router->with('/api', function () use ($router) {
            $router->respond('POST', '/callback', function($request, $response) {
                $data = $request->params(['name', 'phone', 'message']);
                return $response->json((object) App::requestCallback($data));
            });
        });
        return $router;
    }
}