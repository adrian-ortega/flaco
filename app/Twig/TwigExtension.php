<?php

namespace AOD\Twig;

use Interop\Container\ContainerInterface;
use Slim\Views\TwigExtension as SlimTwigExtension;

class TwigExtension extends SlimTwigExtension
{
    /**
     * App Container
     * @var ContainerInterface
     */
    protected $container;

    /**
     * array of custom extensions
     * @var Array
     */
    protected $extensions = [];

    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
        $this->setupCustomExtensions();

        parent::__construct(
            $container->get('router'),
            $container->get('request')->getUri()
        );
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        $filters = parent::getFilters();

        foreach($this->extensions as $ext) {
            $filters = array_merge($filters, $ext->getFilters());
        }

        return $filters;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        $functions = parent::getFunctions();

        foreach($this->extensions as $ext) {
            $functions = array_merge($functions, $ext->getFunctions());
        }

        return $functions;
    }

    public function setupCustomExtensions()
    {
        $prefix = '\\AOD\\Twig\\Extensions\\';
        $path = APP_PATH . 'Twig' . DS . 'Extensions' . DS;

        $ignore_files = [
            '.', '..',
            '.DS_Store', '.AppleDouble', '.LSOverride', '.trash',
            'Thumbs.db', 'ehthumbs.db', '$RECYCLE.BIN'
        ];

        $classes = [];

        if(file_exists( $path )) {
            $handle = opendir($path);

            while($file = readdir($handle)) {

                if(in_array($file, $ignore_files))
                    continue;

                if(class_exists($class = $prefix . str_replace('.php', '', $file)))
                    $classes[] = $class;
            }
        }

        foreach($classes as $ext) {
            $this->extensions[] = new $ext( $this->container );
        }

        return $this;
    }
}