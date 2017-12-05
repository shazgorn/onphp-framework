<?php

/***************************************************************************
 *   Copyright (C) 2009 by Solomatin Alexandr                              *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

namespace Onphp;

class WebAppControllerResolverHandler implements InterceptingChainHandler
{
    const
        CONTROLLER_POSTFIX = 'Controller',
        CONTROLLER_NAMESPACE = "Controllers" . '\\';

    protected $defaultController = 'HomeController';

    protected $notfoundController = 'NotFoundController';

    /** bool won`t do you any good because of the router hacks */
    protected $useDefaultController = false;

    /**
     * @return WebAppControllerResolverHandler
     */
    public function run(InterceptingChain $chain)
    {
        if ($controllerName = $this->getControllerNameByArea($chain)) {
            $chain->setControllerName($controllerName);
        } elseif ($this->useDefaultController) {
            $chain->setControllerName(self::CONTROLLER_NAMESPACE . $this->defaultController);
        } else {
            HeaderUtils::sendHttpStatus(new HttpStatus(HttpStatus::CODE_404));
            $chain->setControllerName(self::CONTROLLER_NAMESPACE . $this->notfoundController);
        }
        $chain->next();

        return $this;
    }

    /**
     * @param InterceptingChain $chain
     * @return null|string
     */
    protected function getControllerNameByArea(InterceptingChain $chain)
    {
        /** @var WebApplication $chain */
        /** @var HttpRequest $request */
        $request = $chain->getRequest();
        $area = null;

        if ($request->hasAttachedVar('area')) {
            $area = $request->getAttachedVar('area');
        } elseif ($request->hasGetVar('area')) {
            $area = $request->getGetVar('area');
        } elseif ($request->hasPostVar('area')) {
            $area = $request->getPostVar('area');
        }
        if ($area) {
            if ($request->hasAttachedVar('namespaces')) {
                $area = $request->getAttachedVar('namespaces') . ucfirst($area);
            } else {
                $area = self::CONTROLLER_NAMESPACE . ucfirst($area);
            }
            if ($this->checkControllerName($area . self::CONTROLLER_POSTFIX)) {
                return $area . self::CONTROLLER_POSTFIX;
            }
        } elseif (!$this->useDefaultController) {
            if (defined('__LOCAL_DEBUG__')) {
                throw new WrongStateException('area is not set');
            }
        }
        return null;
    }

    protected function checkControllerName($controllerName)
    {
        try {
            new $controllerName;
            return true;
        } catch (\Exception $e) {
            if (defined('__LOCAL_DEBUG__')) {
                throw $e;
            }
            return false;
        }
    }

    /**
     * @return WebAppControllerResolverHandler
     */
    public function setDefaultController($defaultController)
    {
        $this->defaultController = $defaultController;

        return $this;
    }

    /**
     * @return WebAppControllerResolverHandler
     */
    public function setNotfoundController($notfoundController)
    {
        $this->notfoundController = $notfoundController;

        return $this;
    }

    /**
     * Use $defaultController when controller not found instead of $notfoundController
     * @param bool $useDefaultInsteadNotFound
     */
    public function setUseDefaultController($useDefaultController)
    {
        $this->useDefaultController = $useDefaultController;

        return $this;
    }
}
