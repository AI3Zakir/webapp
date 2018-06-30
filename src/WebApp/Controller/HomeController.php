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

class HomeController extends Controller
{

    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * HomeController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->newsRepository = new NewsRepository();
    }

    /**
     * '/' - route
     *
     * @return array
     */
    public function home(): array
    {
        return ['news' => $this->newsRepository->getAll()];
    }
}