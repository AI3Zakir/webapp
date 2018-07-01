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
use WebApp\Response\Base\ResponseInterface;
use WebApp\Response\RedirectResponse;
use WebApp\Response\ViewResponse;

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
     * NewsController constructor.
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
     * @return ResponseInterface
     */
    public function showNews(): ResponseInterface
    {
        return new ViewResponse('News/showNews.html.twig', ['news' => $this->newsRepository->getAll()]);
    }

    /**
     * GET /news/add/ - route
     *
     * @return ResponseInterface
     */
    public function addNews(): ResponseInterface
    {
        return new ViewResponse('News/addNews.html.twig', ['authors' => $this->authorRepository->getAll()]);
    }

    /**
     * POST /news/add/ - route
     *
     * @return ResponseInterface
     */
    public function postNews(): ResponseInterface
    {
        $id = $this->getRequest()['id'] ?? null;

        $news = $this->newsRepository->getById($id);

        if (!$news) {
            $result = $this->newsRepository->insert($this->getRequest());

            return $result ? new RedirectResponse('/news') : new RedirectResponse('/news/add');
        }

        $result = $this->newsRepository->update($this->getRequest(), $id);

        return $result ? new RedirectResponse('/news') : new RedirectResponse('/news/edit?id='.$id);
    }

    /**
     * GET /news/add/ - route
     *
     * @return ResponseInterface
     */
    public function editNews(): ResponseInterface
    {
        $news = $this->newsRepository->getById($this->getRequest()['id']);

        return new ViewResponse('News/editNews.html.twig', ['authors' => $this->authorRepository->getAll(), 'news' => $news]);
    }

    /**
     * DELETE /news/delete/ - route
     *
     * @return ResponseInterface
     */
    public function deleteNews(): ResponseInterface
    {
        $id = $this->getRequest()['id'] ?? null;

        $news = $this->newsRepository->getById($id);

        if(!$news) {
            return new RedirectResponse('/news');
        }

        if ('POST' === $this->getMethod()) {
            $this->newsRepository->deleteById($id);

            return new RedirectResponse('/news');
        }

        return new ViewResponse('News/deleteNews.html.twig', ['news' => $news]);
    }
}