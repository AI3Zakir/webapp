<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 4:23 AM
 */

namespace WebApp\Core;

class Application
{
    private $controller;
    private $action;

    /**
     * @var Router
     */
    private $router;

    /**
     * Application constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * start the applications
     */
    public function run()
    {
        $controller = $this->router->findMatch();

        if ($controller) {

        } else {
            echo 'No route';
        }
    }
}