<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 3:43 PM
 */

namespace WebApp\Controller;


use WebApp\Controller\Base\Controller;
use WebApp\Repository\NewsRepository;
use WebApp\Response\Base\ResponseInterface;
use WebApp\Response\ViewResponse;

/**
 * Class HomeController
 * @package WebApp\Controller
 */
class HomeController extends Controller
{

    /**
     * '/' - route
     *
     * @return ResponseInterface
     */
    public function home(): ResponseInterface
    {
        return new ViewResponse('Home/home.html.twig');
    }
}