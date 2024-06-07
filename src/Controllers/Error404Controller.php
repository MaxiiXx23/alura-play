<?php

namespace Max\Aluraplay\Controllers;

class Error404Controller
{

    public function execute()
    {
        // informo ao navegado o statusCode HTTP
        http_response_code(404);
    }
}
