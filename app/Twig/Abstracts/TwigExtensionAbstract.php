<?php

namespace AOD\Twig\Abstracts;

use Interop\Container\ContainerInterface;

abstract class TwigExtensionAbstract
{
    /**
     * The app container
     * @var ContainerInterface
     */
    protected $container;

    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return [];
    }

    public function getFilters()
    {
        return [];
    }
}