<?php

use Interop\Container\ContainerInterface;

// Paths to be used throughout the app
if(!defined('DS'))          { define('DS', DIRECTORY_SEPARATOR); }
if(!defined('ABS_PATH'))    { define('ABS_PATH', realpath(__DIR__ . '/../') . DS); }
if(!defined('PUBLIC_PATH')) { define('PUBLIC_PATH', realpath(__DIR__ . '/../../wwwroot') . DS); }
if(!defined('BOOT_PATH'))   { define('BOOT_PATH', ABS_PATH . 'bootstrap' . DS); }
if(!defined('APP_PATH'))    { define('APP_PATH', ABS_PATH . 'app' . DS); }

$autoloader = ABS_PATH . 'vendor' . DS . 'autoload.php';

// Check to see if we've created the autoloader file in the composer vendor dir
if(!file_exists($autoloader)) {
    echo '<h1>Can\'t find vendor/autoload.php. </h1>';
    echo '<h3>Please install all required composer vendor dependencies</h3>';
    die();
}

require_once $autoloader;

try {
    (new Dotenv\Dotenv(ABS_PATH))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Slim\App([
    'app' => [
        'name' => getenv('APP_NAME'),
        'ssl' => getenv('FORCE_SSL') === true,
        'debug' => getenv('APP_DEBUG') === true,
    ],

    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === true,
    ],

    // The app/site url
    'base_url' => function( ContainerInterface $c ) {
        $force_ssl = $c->app['ssl'] || 
                ((!isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] !== 'off')) || 
                ($_SERVER['SERVER_PORT'] == 443));

        $protocol = $force_ssl ? "https://" : "http://";
        
        return $protocol . $_SERVER['HTTP_HOST'];
    },

    // Twig template engine
    'view' => function( ContainerInterface $c) {
        $resources_path = ABS_PATH . 'resources' . DS;

        $twig = new Slim\Views\Twig( $resources_path . 'views', [
            'cache' => $c->app['debug'] ? $resources_path . 'cache' : false,
            'debug' => $c->app['debug']
        ]);

        if($c->app['debug'])
            $twig->addExtension( new \Twig_Extension_Debug() );

        $twig->addExtension( new AOD\Twig\TwigExtension( $c ) );

        return $twig;
    }
]);

require_once ABS_PATH . 'routes' . DS .'web.php';