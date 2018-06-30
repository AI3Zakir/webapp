<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 4:23 AM
 */

namespace WebApp\Core;

use http\Env\Request;
use Twig_Extension_Debug;
use WebApp\Controller\Base\Controller;

class Application
{
    /**
     * @var Controller
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var array
     */
    private $request;

    /**
     * @var array
     */
    private $query;

    /**
     * Application constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->setRequest();
        $this->setQuery();

        $loader = new \Twig_Loader_Filesystem('views/');
        $this->twig = new \Twig_Environment($loader, [
            'debug' => true
        ]);
        $this->twig->addExtension(new Twig_Extension_Debug());
    }

    /**
     * start the applications
     */
    public function run()
    {
        $controller = $this->router->findMatch();

        if ($controller) {
            $controllerName = 'WebApp\\Controller\\' . $controller[Router::CONTROLLER];
            $this->controller = new $controllerName();
            $this->controller->setRequest($this->request);
            $this->action = $controller[Router::ACTION];
            $data = $this->controller->{$this->action}();
            try {
                echo $this->twig->render($this->getTemplate(), $data);
            } catch (\Twig_Error_Loader $e) {
                echo $e->getMessage();
            } catch (\Twig_Error_Runtime $e) {
                echo $e->getMessage();
            } catch (\Twig_Error_Syntax $e) {
                echo $e->getMessage();
            }
        } else {
            echo 'No route';
        }
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return end(str_replace('Controller', '', explode('\\', \get_class($this->controller)))) . '/' . $this->action . '.html.twig';
    }

    /**
     * Set Request
     */
    private function setRequest(): void
    {
        $this->request = $_REQUEST;
    }

    private function setQuery()
    {
        $this->query = $_GET;
    }
}