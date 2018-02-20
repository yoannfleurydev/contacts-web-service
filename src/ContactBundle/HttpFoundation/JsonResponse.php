<?php

namespace ContactBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;

class JsonResponse extends Response {

    static function OK($content): Response {
        return new Response(
            $content,
            Response::HTTP_OK,
            ["Content-Type" => "application/json"]
        );
    }

    static function CREATED($content): Response {
        return new Response(
            $content,
            Response::HTTP_CREATED,
            ["Content-Type" => "application/json"]
        );
    }

    static function NO_CONTENT(): Response {
        return new Response(
            '',
            Response::HTTP_NO_CONTENT,
            ["Content-Type" => "application/json"]
        );
    }
}
