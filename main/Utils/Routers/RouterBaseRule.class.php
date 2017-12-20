<?php
/***************************************************************************
 *   Copyright (C) 2008 by Sergey S. Sergeev                               *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

namespace Onphp;

abstract class RouterBaseRule implements RouterRule
{
    protected $defaults = array();

    /**
     * @return \Onphp\RouterChainRule
     **/
    public function chain(RouterRule $route, $separator = '/')
    {
        $chain = new RouterChainRule();

        $chain->
            chain($this)->
            chain($route, $separator);

        return $chain;
    }

    public function getDefault($name)
    {
        if (isset($this->defaults[$name])) {
            return $this->defaults[$name];
        }

        return null;
    }

    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     * @return array
     **/
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @return \Onphp\HttpUrl
     **/
    protected function getPath(HttpUrl $url)
    {
        $reducedUrl = clone $url;

        $base = RouterRewrite::me()->getBaseUrl();

        if (!$base instanceof HttpUrl)
            throw new RouterException('Setup base url');

        if (!$base->getScheme()) {
            $reducedUrl->
                setScheme(null)->
                setAuthority(null);
        }

        $reducedUrl->setQuery(null);

        if (
            (
                $reducedUrl->getScheme()
                && ($base->getScheme() != $reducedUrl->getScheme())
            ) || (
                $reducedUrl->getAuthority()
                && ($base->getAuthority() != $reducedUrl->getAuthority())
            )
        ) {
            return $reducedUrl;
        }

        $result = HttpUrl::create();

        $baseSegments = explode('/', $base->getPath());
        $segments = explode('/', $reducedUrl->getPath());

        $originalSegments = $segments;

        array_pop($baseSegments);

        while (
            $baseSegments
            && $segments
            && ($baseSegments[0] == $segments[0])
        ) {
            array_shift($baseSegments);
            array_shift($segments);
        }

        if ($baseSegments && $baseSegments[0])
            $segments = $originalSegments;

        $result->setPath(implode('/', $segments));

        return $result;
    }

    /**
     * @return \Onphp\HttpUrl
     **/
    protected function processPath(HttpRequest $request)
    {
        // One can override REQUEST_URI via `pathToProcess` variable
        // for some custom routes, files etc
        if ($request->hasAttachedVar('requestUri')) {
            $path =
                $this->getPath(
                    HttpUrl::create()->parse($request->getAttachedVar('requestUri'))
                );
        } elseif ($request->hasServerVar('REQUEST_URI')) {
            $path =
                $this->getPath(
                    HttpUrl::create()->parse($request->getServerVar('REQUEST_URI'))
                );
        } else {
            throw new RouterException('Cannot resolve path. REQUEST_URI or `pathToProcess` is not set');
        }

        return $path;
    }
}
?>
