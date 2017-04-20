<?php

namespace App;

use Klein\Klein;
use Core\View as v;

class Api {
    static function router() {
        $router = new Klein();
        $router->with('/api', function () use ($router) {
            $router->respond('POST', '/callback', function($request, $response) {
                $params = $request->params(['name', 'phone', 'message']);
                $result = App::requestCallback($params);
                return v::twig()->render(v::partial('modals/callback_form.twig'), [
                    'params' => $params,
                    'result' => $result
                ]);
            });
        });
        return $router;
    }
}