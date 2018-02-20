<?php

namespace ContactBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;

class JsonResponse extends Response {

    static function OK($content): Response {
        return new Response(
            $content,
            Response::OK,
            ["Content-Type" => "application/json"]
        );
    }

    static function CREATED($content): Response {
        return new Response(
            $content,
            Response::CREATED,
            ["Content-Type" => "application/json"]
        );
    }
}
