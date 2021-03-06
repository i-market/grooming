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
            $router->respond('POST', '/taxi-request', function($request, $response) {
                $params = $request->params(['name', 'phone', 'message', 'option-id']);
                $result = App::requestTaxi($params);
                return v::twig()->render(v::partial('modals/taxi_request_form.twig'), [
                    'params' => $params,
                    'result' => $result
                ]);
            });
            $router->respond('POST', '/booking', function($request, $response) {
                $params = $request->params(['name', 'phone', 'period', 'pet_description', 'option-id']);
                $result = App::bookingRequest($params);
                return v::twig()->render(v::partial('modals/booking_form.twig'), [
                    'params' => $params,
                    'result' => $result
                ]);
            });
        });
        return $router;
    }
}