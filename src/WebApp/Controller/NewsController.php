<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 7:11 PM
 */

namespace WebApp\Controller;

use WebApp\Controller\Base\Controller;
use WebApp\Repository\AuthorRepository;
use WebApp\Repository\NewsRepository;

class NewsController extends Controller
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * @var AuthorRepository
     */
    private $authorRepository;
    /**
     * HomeController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->newsRepository = new NewsRepository();
        $this->authorRepository = new AuthorRepository();
    }

    /**
     * GET '/news/' - route
     *
     * @return array
     */
    public function showNews(): array
    {
        return ['news' => $this->newsRepository->getAll()];
    }

    /**
     * GET /news/add/ - route
     *
     * @return array
     */
    public function addNews(): array
    {
        return ['authors' => $this->authorRepository->getAll()];
    }

    /**
     * POST /news/add/ - route
     *
     * Redirection
     * @return string
     */
    public function postNews(): string
    {
        if (isset($this->getRequest()['id'])) {
            $id = $this->getRequest()['id'];
            $news = $this->newsRepository->getById($id);
            if($news) {
                $result = $this->newsRepository->update($this->getRequest(), $id);
            }
        } else {
            $result = $this->newsRepository->insert($this->getRequest());
        }
        if ($result) {
            return '/news';
        }

        return '/news/add';
    }

    /**
     * GET /news/add/ - route
     *
     * @return array
     */
    public function editNews(): array
    {
        $news = $this->newsRepository->getById($this->getRequest()['id']);

        return ['authors' => $this->authorRepository->getAll(), 'news' => $news];
    }

    /**
     * DELETE /news/delete/ - route
     *
     * @return string|array
     */
    public function deleteNews()
    {
        if (isset($this->getRequest()['id'])) {
            $id = $this->getRequest()['id'];
            $news = $this->newsRepository->getById($id);
        }
        if (isset($id) && 'POST' === $this->getMethod()) {
            if(isset($news)) {
                $this->newsRepository->deleteById($id);
            }
            return '/news';
        }

        return ['news' => $news];

    }
}