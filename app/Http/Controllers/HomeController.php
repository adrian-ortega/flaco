<?php

namespace AOD\Http\Controllers;

use AOD\Http\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends Controller
{
    public function getIndex( Request $request, Response $response )
    {
        return $this->render($response, 'home/index.twig', [
            'app_name' => $this->container->app['name']
        ]);
    }
}