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

class AuthorController extends Controller
{
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
        $this->authorRepository = new AuthorRepository();
    }

    /**
     * GET '/author/' - route
     *
     * @return array
     */
    public function showAuthors(): array
    {
        return ['authors' => $this->authorRepository->getAll()];
    }

    /**
     * GET /author/add/ - route
     *
     * @return array
     */
    public function addAuthor(): array
    {
        return ['author' => $this->authorRepository->getAll()];
    }

    /**
     * POST /author/add/ - route
     *
     * Redirection
     * @return string
     */
    public function postAuthor(): string
    {
        if (isset($this->getRequest()['id'])) {
            $id = $this->getRequest()['id'];
            $author = $this->authorRepository->getById($id);
            if($author) {
                $result = $this->authorRepository->update($this->getRequest(), $id);
            }
        } else {
            $result = $this->authorRepository->insert($this->getRequest());
        }
        if ($result) {
            return '/authors';
        }

        return '/author/add';
    }

    /**
     * GET /author/add/ - route
     *
     * @return array
     */
    public function editAuthor(): array
    {
        $author = $this->authorRepository->getById($this->getRequest()['id']);

        return ['author' => $author];
    }

    /**
     * DELETE /author/delete/ - route
     *
     * @return string|array
     */
    public function deleteAuthor()
    {
        if (isset($this->getRequest()['id'])) {
            $id = $this->getRequest()['id'];
            $author = $this->authorRepository->getById($id);
        }
        if (isset($id) && 'POST' === $this->getMethod()) {
            if(isset($author)) {
                $this->authorRepository->deleteById($id);
            }
            return '/authors';
        }

        return ['author' => $author];

    }
}