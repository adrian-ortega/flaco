<?php

namespace AOD\Twig\Extensions;

use AOD\Twig\Abstracts\TwigExtensionAbstract;

class Assets extends TwigExtensionAbstract
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_image', [$this, 'getImage']),
            new \Twig_SimpleFunction('get_script', [$this, 'getScript']),
            new \Twig_SimpleFunction('get_stylesheet', [$this, 'getStylesheet']),
            new \Twig_SimpleFunction('get_vendor_script', [$this, 'getVendorScript']),
        ];
    }

    protected function getAssetDir($dir = '')
    {
        return $this->container->base_url . '/assets/' . ( !empty($dir) ? $dir . '/' : '' );
    }

    protected function getAssetPath($dir = '')
    {
        return PUBLIC_PATH . 'assets' . DS . (!empty($dir) ? $dir . DS : '');
    }

    public function getImage($file = '')
    {
        return $this->getAssetDir('images') . $file;
    }

    public function getScript($file, $sub = null)
    {
        $file = empty($sub) ? $file : "$sub/$file";

        return $this->getAssetDir('scripts') . $file;
    }

    public function getVendorScript($file = '')
    {
        return $this->getScript($file, 'vendor');
    }

    public function getStylesheet($file = '')
    {
        return $this->getAssetDir('styles') . $file;
    }
}