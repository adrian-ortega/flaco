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

    /**
     * Returns an array of functions to register
     * @return array|\Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [];
    }

    /**
     * Returns an array of filters to register
     * @return array|\Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [];
    }
}