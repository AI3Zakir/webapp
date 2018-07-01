<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 3:23 PM
 */

namespace WebApp\Core;


class Router
{
    public const METHOD = 0;
    public const CONTROLLER = 1;
    public const ACTION = 2;

    /**
     * @var array
     */
    private $routes;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $method;

    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
        $this->setUri();
        $this->setMethod();
    }

    /**
     * @return bool|mixed
     */
    public function findMatch()
    {
        foreach ($this->routes as $route => $controller) {
            if (\is_array($controller)) {
                foreach ($controller as $subControllers) {
                    if ($route === $this->uri && $subControllers[self::METHOD] === $this->method) {
                        return $subControllers;
                    }
                }
            }
            if ($route === $this->uri && $controller[self::METHOD] === $this->method) {
                return $controller;
            }
        }

        return false;
    }

    /**
     * set uri from $_SERVER variable
     */
    private function setUri(): void
    {
        $this->uri = strtok($_SERVER['REQUEST_URI'],'?');
    }

    /**
     * set method
     */
    private function setMethod(): void
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
}