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

    /**
     * Directory url for assets
     * @param  string $dir
     * @return string
     */
    protected function getAssetDir($dir = '')
    {
        return $this->container->base_url . '/assets/' . ( !empty($dir) ? $dir . '/' : '' );
    }

    /**
     * Returns the server path for an asset directory.
     * @todo Adrian Ortega - add file exist check for min files
     * 
     * @param  string $dir
     * @return string
     */
    protected function getAssetPath($dir = '')
    {
        return PUBLIC_PATH . 'assets' . DS . (!empty($dir) ? $dir . DS : '');
    }

    /**
     * Returns the url for a specific image
     * @param  string $file
     * @return string
     */
    public function getImage($file = '')
    {
        return $this->getAssetDir('images') . $file;
    }

    /**
     * Returns the url for a specific script file.
     * @param  string $file
     * @param  string $sub
     * @return string
     */
    public function getScript($file = '', $sub = null)
    {
        $file = empty($sub) ? $file : "$sub/$file";

        return $this->getAssetDir('scripts') . $file;
    }

    /**
     * Returns the url for a vendor script
     * @param  string $file
     * @return string
     */
    public function getVendorScript($file = '')
    {
        return $this->getScript($file, 'vendor');
    }

    /**
     * Returns the url for a stylesheet
     * @param  string $file
     * @return string
     */
    public function getStylesheet($file = '')
    {
        return $this->getAssetDir('styles') . $file;
    }
}