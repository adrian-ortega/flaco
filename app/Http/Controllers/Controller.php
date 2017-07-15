<?php

namespace AOD\Http\Controllers;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{
    protected $container;

    public function __construct( ContainerInterface &$container )
    {
        $this->container = $container;
    }

    /**
     * Twigg::render() wrapper
     * @param  Response|\Slim\Http\Response $response
     * @param  string $template
     * @param  array $data
     * @return Response|\Slim\Http\Response
     */
    public function render(Response $response, $template = '', $data = [])
    {
        return $this->container->view->render($response, $template, $data);
    }
}