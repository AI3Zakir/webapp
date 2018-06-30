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
    }

    public function findMatch()
    {
        foreach ($this->routes as $route => $controller) {
            if ($route === $this->uri && $controller[self::METHOD]) {
                return $controller;
            }
        }

        return false;
    }

    private function setUri(): void
    {
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    private function setMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
}