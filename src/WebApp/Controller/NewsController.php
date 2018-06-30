<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 7:11 PM
 */

namespace WebApp\Controller;

use WebApp\Controller\Base\Controller;
use WebApp\Repository\NewsRepository;

class NewsController extends Controller
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
    public function showNews(): array
    {
        return ['news' => $this->newsRepository->getAll()];
    }
}