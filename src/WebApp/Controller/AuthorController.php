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
use WebApp\Response\Base\ResponseInterface;
use WebApp\Response\RedirectResponse;
use WebApp\Response\ViewResponse;

class AuthorController extends Controller
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * AuthorController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->authorRepository = new AuthorRepository();
    }

    /**
     * GET '/author/' - route
     *
     * @return ResponseInterface
     */
    public function showAuthors(): ResponseInterface
    {
        return new ViewResponse('Author/showAuthors.html.twig', ['authors' => $this->authorRepository->getAll()]);
    }

    /**
     * GET /author/add/ - route
     *
     * @return ResponseInterface
     */
    public function addAuthor(): ResponseInterface
    {
        return new ViewResponse('Author/addAuthor.html.twig');
    }

    /**
     * POST /author/add/ - route
     *
     * @return ResponseInterface
     */
    public function postAuthor(): ResponseInterface
    {
        $id = $this->getRequest()['id'] ?? null;

        $author = $this->authorRepository->getById($id);

        if (!$author) {
            $result = $this->authorRepository->insert($this->getRequest());

            return $result ? new RedirectResponse('/authors') : new RedirectResponse('/author/add');
        }

        $result = $this->authorRepository->update($this->getRequest(), $id);

        return $result ? new RedirectResponse('/authors') : new RedirectResponse('/author/edit?id='.$id);
    }

    /**
     * GET /author/add/ - route
     *
     * @return ResponseInterface
     */
    public function editAuthor(): ResponseInterface
    {
        $author = $this->authorRepository->getById($this->getRequest()['id']);

        return new ViewResponse('Author/editAuthor.html.twig', ['author' => $author]);
    }

    /**
     * DELETE /author/delete/ - route
     *
     * @return ResponseInterface
     */
    public function deleteAuthor(): ResponseInterface
    {
        $id = $this->getRequest()['id'] ?? null;

        $author = $this->authorRepository->getById($id);

        if(!$author) {
            return new RedirectResponse('/authors');
        }

        if ('POST' === $this->getMethod()) {
            $this->authorRepository->deleteById($id);

            return new RedirectResponse('/authors');
        }

        return new ViewResponse('Author/deleteAuthor.html.twig', ['author' => $author]);
    }
}