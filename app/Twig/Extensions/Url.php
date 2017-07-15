<?php

namespace AOD\Twig\Extensions;

use AOD\Twig\Abstracts\TwigExtensionAbstract;

class Url extends TwigExtensionAbstract
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('site_url', [$this, 'getSiteUrl']),
            new \Twig_SimpleFunction('url_for', [$this, 'getUrlFor']),
            new \Twig_SimpleFunction('current_url', [$this, 'getCurrentUrl']),
            new \Twig_SimpleFunction('current_path', [$this, 'getCurrentPath'])
        ];
    }

    public function getSiteUrl($path = '')
    {
        return $this->container->base_url . $path;
    }

    public function getUrlFor($routeName = '', $data = [], $queryParams = [])
    {
        return $this->getSiteUrl($this->container->router->pathFor($routeName, $data, $queryParams));
    }

    public function getCurrentUrl($withQueryString = true)
    {
        $uri = $this->siteUrl($this->container->request->getUri()->getPath());

        if ($withQueryString) {
            $env = $this->cotainer->environment;

            if ($env['QUERY_STRING'])
                $uri .= '?' . $env['QUERY_STRING'];
        }

        return $uri;
    }

    public function getCurrentPath()
    {
        return $this->container->request->getUri()->getPath();
    }
}