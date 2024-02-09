<?php

use Slim\Views\PhpRenderer;

class ContentRenderer
{

    public static function renderJSON($response, $data)
    {
        $code = isset($data['code']) ? $data['code'] : 200;
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}

?>